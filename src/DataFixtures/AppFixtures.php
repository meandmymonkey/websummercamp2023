<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\UserFactory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'username' => 'jane',
            'email' => 'jane.doe@example.com'
        ]);
        UserFactory::createOne([
            'username' => 'john',
            'email' => 'john.doe@example.com'
        ]);
        UserFactory::createOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'isAdmin' => true
        ]);
        UserFactory::createMany(17);
    }
}
