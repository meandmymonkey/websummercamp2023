<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Serializer\Ignore]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $username;

    #[ORM\Column(type: Types::STRING)]
    private string $email;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Serializer\Ignore]
    private string $password;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isAdmin;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    public function __construct(string $username, string $email, string $password, DateTimeImmutable|null $createdAt = null, $isAdmin = false)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->isAdmin = $isAdmin;
    }

    public function getDisplayName(): string
    {
        return sprintf('%s (%s)', $this->getUsername(), $this->getEmail());
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];

        if ($this->isAdmin) {
            $roles[] = 'ROLE_ADMIN';
        }

        return $roles;
    }

    public function promoteToAdmin(): void
    {
        $this->isAdmin = true;
    }

    public function demoteToUser(): void
    {
        $this->isAdmin = false;
    }

    public function eraseCredentials(): void
    {
        // noop
    }

    #[Serializer\Ignore]
    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }
}
