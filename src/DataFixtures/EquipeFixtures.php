<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $equipe = new Equipe();
            $equipe->setNom('Tyn1');
            $equipe->setLienPrototype('https://google.com');
            $manager->persist($equipe);
        }

        $manager->flush();
    }
}
