<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[AsController]
#[IsGranted('ROLE_USER')]
#[Route(path: '/profile', name: 'profile', methods: ['GET'])]
final class ProfileController
{
    public function __invoke(#[CurrentUser] User|null $user, Environment $twig): Response
    {
        return new Response($twig->render('profile.html.twig', ['user' => $user]));
    }
}
