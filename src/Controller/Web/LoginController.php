<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController]
#[Route(path: '/login', name: 'login', methods: ['GET'])]
final class LoginController
{
    public function __invoke(Environment $twig): Response
    {
        return new Response($twig->render('security/login.html.twig'));
    }
}
