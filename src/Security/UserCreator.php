<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final class UserCreator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PasswordHasherFactoryInterface $hasherFactory
    ) {
    }

    public function create(Registration $registration): User
    {
        $password = $this->hasherFactory->getPasswordHasher(User::class)->hash($registration->password);

        $user = new User($registration->username, $registration->email, $password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
