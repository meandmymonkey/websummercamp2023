<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

#[AsController]
#[Route(path: '/login', name: 'login', methods: ['GET', 'POST'])]
final class LoginController
{
    public function __invoke(Environment $twig, AuthenticationUtils $utils): Response
    {
        return new Response($twig->render(
            'security/login.html.twig',
            [
                'error' => $utils->getLastAuthenticationError(),
                'last_username' => $utils->getLastUsername()
            ]
        ));
    }
}
