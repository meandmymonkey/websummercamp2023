<?php

declare(strict_types=1);

namespace App\Security\Authentication;

use App\Repository\UserRepository;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\String\UnicodeString;
use function Symfony\Component\String\u;

final class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(private readonly Configuration $configuration)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $this->getAuthHeader($request)->startsWith('Bearer ');
    }

    public function authenticate(Request $request): Passport
    {
        $tokenValue = $this->getAuthHeader($request)
            ->after('Bearer ')
            ->toString();

        $jwt = $this->configuration->parser()->parse($tokenValue);

        $constraints = [
            new SignedWith($this->configuration->signer(), $this->configuration->signingKey()),
            new StrictValidAt(SystemClock::fromUTC())
        ];

        if (!$this->configuration->validator()->validate($jwt, ...$constraints)) {
            throw new BadCredentialsException();
        }

        return new SelfValidatingPassport(new UserBadge($jwt->claims()->get('sub')));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response(status: Response::HTTP_UNAUTHORIZED);
    }

    private function getAuthHeader(Request $request): UnicodeString
    {
        return u($request->headers->get('Authorization', ''));
    }
}
