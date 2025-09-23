<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture implements FixtureGroupInterface
{
    public const NB_EQUI = 3;
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $equipe = new Equipe();
            $equipe->setNom('Tyn1');
            $equipe->setLienPrototype('https://google.com');
            $manager->persist($equipe);

            $this->addReference('equipe_'.$i, $equipe);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
