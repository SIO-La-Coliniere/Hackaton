<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $inscription = new Inscription();
            $inscription->setNum('1');
            $inscription->setDate(new \DateTime('1990-01-01'));
            $inscription->setCompetence('informatique');
            $manager->persist($inscription);
        }

        $manager->flush();
    }
}
