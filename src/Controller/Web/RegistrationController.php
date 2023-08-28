<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Form\RegistrationType;
use App\Security\UserCreator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

#[AsController]
#[Route(path: '/register', name: 'register', methods: ['GET', 'POST'])]
final class RegistrationController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly FormFactoryInterface $formFactory,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly UserCreator $userCreator
    ){
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userCreator->create($form->getData());

            return new RedirectResponse($this->urlGenerator->generate('home'));
        }

        return new Response(
            $this->twig->render(
                'security/register.html.twig',
                ['form_view' => $form->createView()]
            )
        );
    }
}
