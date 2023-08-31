<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[AsController]
#[IsGranted('ROLE_ADMIN')]
#[Route(path: '/users', name: 'users_list', methods: ['GET'])]
final class UserListController
{
    public function __invoke(UserRepository $repository, Environment $twig): Response
    {
        return new Response(
            $twig->render(
                'users/list.html.twig',
                ['users' => $repository->findAll()]
            )
        );
    }
}
