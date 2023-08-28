<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Validator\Constraints as Assert;

final class Registration
{
    #[Assert\NotBlank]
    public string $username;

    #[Assert\NotBlank]
    #[Assert\Email(mode: Assert\Email::VALIDATION_MODE_STRICT)]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    public string $password;
}
