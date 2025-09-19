<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 10; ++$i) {
            $participant = new Participant();
            $participant->setNom('Johnny');
            $participant->setPrenom('Doe');
            $participant->setDateNaissance(new \DateTime('1990-01-01'));
            $participant->setEmail('Johnny Doe@example.com');
            $participant->setTelephone('0123456789');
            $participant->setLienPortefolio('https://github.com/JohnnyDoe');
            $manager->persist($participant);
        }

        $manager->flush();
    }
}
