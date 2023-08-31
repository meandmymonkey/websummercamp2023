<?php

namespace App\Controller\Web;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
final class ResetGoogleAuthenticatorController
{
    #[Route(path: '/reset-authenticator', name: 'app_reset_google_authenticator')]
    public function __invoke(
        #[CurrentUser] User|null $user,
        GoogleAuthenticatorInterface $googleAuthenticator,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        Session $session
    ): Response {
        $user->setGoogleAuthenticatorSecret($googleAuthenticator->generateSecret());
        $entityManager->flush();

        $session->getFlashBag()->add('2fa_reset_google_authenticator', true);

        return new RedirectResponse($urlGenerator->generate('profile'));
    }
}
