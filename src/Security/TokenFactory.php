<?php

declare(strict_types=1);

namespace App\Security;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Symfony\Component\Security\Core\User\UserInterface;

final class TokenFactory
{
    public function __construct(
        private readonly Configuration $configuration,
        private readonly string $host = 'https://localhost',
        private readonly int $ttl = 3600,
        private readonly int $delay = 1
    ) {
    }

    public function forUser(UserInterface $user): Token
    {
        $now = new DateTimeImmutable();

        return $this->configuration->builder()
            ->issuedAt($now)
            ->expiresAt($now->modify(sprintf('+%s seconds', $this->ttl)))
            ->canOnlyBeUsedAfter($now->modify(sprintf('+%s seconds', $this->delay)))
            ->issuedBy($this->host)
            ->permittedFor($this->host)
            ->relatedTo($user->getUserIdentifier())
            ->withClaim('roles', $user->getRoles())
            ->getToken(
                $this->configuration->signer(),
                $this->configuration->signingKey()
            )
        ;
    }
}
