<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\Inscription;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InscriptionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $inscription = new Inscription();
            $inscription->setNum('1');
            $inscription->setDate(new \DateTime('1990-01-01'));
            $inscription->setCompetence('informatique');

            $participantID = random_int(0, ParticipantFixtures::NB_PART - 1);
            $participant = $this->getReference('participant_' . $participantID, Participant::class);
            $inscription->setParticipant($participant);

            $hackathonID = random_int(0, HackathonFixtures::NB_HACK - 1);
            $hackathon = $this->getReference('hackathon_' . $hackathonID, Hackathon::class);
            $inscription->setHackathon($hackathon);
            $manager->persist($inscription);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [ParticipantFixtures::class, HackathonFixtures::class];
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
