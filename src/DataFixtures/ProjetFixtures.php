<?php

namespace App\DataFixtures;


use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $projet = new Projet();
            $projet->setDescription('Hugo description');
            $projet->setRetenu(true);
            $manager->persist($projet);
        }

        $manager->flush();
    }
}
