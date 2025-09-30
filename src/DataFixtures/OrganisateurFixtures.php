<?php

namespace App\DataFixtures;

use App\Entity\Organisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganisateurFixtures extends Fixture implements FixtureGroupInterface
{
    public const NB_ORGA = 3;
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $organisateur = new Organisateur();
            $organisateur->setStatus('chepa');
            $organisateur->setNom('Patrick');
            $organisateur->setSiteweb('https://patrick.fr');
            $organisateur->setEmail('patrick@gmail.com');

            //$hackathonID = rand(1, HackathonFixtures::NB_HACK - 1);
            //$hackathon = $this->getReference('hackathon_'.$hackathonID, HackathonFixtures::class);
            //$organisateur->addHackathon($hackathon);
            $manager->persist($organisateur);

            $this->addReference('organisateur_' . $i, $organisateur);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
