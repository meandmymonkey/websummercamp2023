<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsController]
#[Route(path: '/', name: 'home', methods: ['GET'])]
final class HomeController
{
    public function __invoke(UrlGeneratorInterface $urlGenerator): Response
    {
        return new RedirectResponse($urlGenerator->generate('users_list'));
    }
}
