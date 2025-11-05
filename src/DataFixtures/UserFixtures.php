<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $user =new User();

        $user->setEmail('admin@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(password_hash('admin', PASSWORD_DEFAULT));
        $manager->persist($user);

        $this->addReference('user', $user);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['make'];
    }
}
