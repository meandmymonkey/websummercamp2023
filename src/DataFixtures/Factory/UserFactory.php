<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<User>
 *
 * @method static User|Proxy     createOne(array $attributes = [])
 * @method static User[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static User[]|Proxy[] createSequence(array|callable $sequence)
 * @method static User|Proxy     find(object|array|mixed $criteria)
 * @method static User|Proxy     findOrCreate(array $attributes)
 * @method static User|Proxy     first(string $sortedField = 'id')
 * @method static User|Proxy     last(string $sortedField = 'id')
 * @method static User|Proxy     random(array $attributes = [])
 * @method static User|Proxy     randomOrCreate(array $attributes = [])
 * @method static User[]|Proxy[] all()
 * @method static User[]|Proxy[] findBy(array $attributes)
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method        User|Proxy     create(array|callable $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    public function __construct(private readonly PasswordHasherFactoryInterface $passwordHasherFactory)
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'username' => self::faker()->userName(),
            'email' => self::faker()->safeEmail(),
            'password' => $this->passwordHasherFactory->getPasswordHasher(User::class)->hash('password'),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-3 years')),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(User $user): void {})
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
