<?php

namespace App\DataFixtures;

use App\Entity\Organisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $organisateur = new Organisateur();
            $organisateur->setStatus('chepa');
            $organisateur->setNom('Patrick');
            $organisateur->setSiteweb('https://patrick.fr');
            $organisateur->setEmail('patrick@gmail.com');
            $manager->persist($organisateur);
        }

        $manager->flush();
    }
}
