<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Security\TokenFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
final class TokenController
{
    #[Route(path: '/api/token', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(#[CurrentUser] ?UserInterface $user, TokenFactory $tokenFactory): JsonResponse
    {
        return new JsonResponse([
            'token' => $tokenFactory->forUser($user)->toString(),
        ]);
    }
}
