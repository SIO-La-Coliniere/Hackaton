<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture implements FixtureGroupInterface
{
    public const NB_PART = 5;
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

            $this->addReference('participant_'.$i, $participant);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
