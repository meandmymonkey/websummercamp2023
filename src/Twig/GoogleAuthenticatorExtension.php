<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class GoogleAuthenticatorExtension extends AbstractExtension
{
    private Security $security;
    private GoogleAuthenticatorInterface $googleAuthenticator;

    public function __construct(GoogleAuthenticatorInterface $googleAuthenticator, Security $security)
    {
        $this->security = $security;
        $this->googleAuthenticator = $googleAuthenticator;
    }

    public function getFunctions(): iterable
    {
        yield new TwigFunction('google_auth_qr_code', [$this, 'generateQrCodeDataUri']);
    }

    public function generateQrCodeDataUri(): string
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($this->googleAuthenticator->getQRContent($user))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(200)
            ->margin(0)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->build()
        ;

        return $qrCode->getDataUri();
    }
}
