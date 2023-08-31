<?php

declare(strict_types=1);

namespace App\Controller\Api;


use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[IsGranted('ROLE_USER')]
#[Route(path: '/api/profile', name: 'api_users_profile', methods: ['GET'])]
final class UserProfileController
{
    public function __invoke(#[CurrentUser] User|null $user, SerializerInterface $serializer): JsonResponse
    {
        if (null === $user) {
            throw new NotFoundHttpException('You are not logged in.');
        }

        return JsonResponse::fromJsonString($serializer->serialize($user, 'json'));
    }
}
