<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[IsGranted('ROLE_ADMIN')]
#[Route(path: '/api/users', name: 'api_users_list', methods: ['GET'])]
final class UserListController
{
    public function __invoke(UserRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        return JsonResponse::fromJsonString($serializer->serialize($repository->findAll(), 'json'));
    }
}
