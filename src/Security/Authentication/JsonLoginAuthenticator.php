<?php

declare(strict_types=1);

namespace App\Security\Authentication;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

final class JsonLoginAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return
            $request->getContentTypeFormat() === 'json' &&
            $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $rawData = json_decode($request->getContent(), true);
        $username = $rawData['username'] ?? '';
        $password = $rawData['password'] ?? '';

        $userBadge = new UserBadge($username);
        $credentials = new PasswordCredentials($password);

        return new Passport($userBadge, $credentials);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response(status: Response::HTTP_UNAUTHORIZED);
    }
}
