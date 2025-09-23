<?php

namespace App\DataFixtures;


use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $projet = new Projet();
            $projet->setDescription('Hugo description');
            $projet->setRetenu(true);

            $equipeID = rand(1, EquipeFixtures::NB_EQUI - 1);
            $equipe = $this->getReference('equipe_'.$equipeID, EquipeFixtures::class);
            $projet->addEquipe($equipe);

            $hackathonID = rand(1, HackathonFixtures::NB_HACK - 1);
            $hackaton = $this->getReference('hackathon_'.$hackathonID, HackathonFixtures::class);
            $projet->addHackathon($hackaton);

            $manager->persist($projet);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [EquipeFixtures::class];
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
