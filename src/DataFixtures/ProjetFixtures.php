<?php

namespace App\DataFixtures;


use App\Entity\Hackathon;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture implements DependentFixtureInterface,FixtureGroupInterface
{
    public const NB_PROJ = 3;
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $projet = new Projet();
            $projet->setDescription('Hugo description');
            $projet->setRetenu(true);
            $manager->persist($projet);

            $hackathonID = rand(1, HackathonFixtures::NB_HACK - 1);
            $hackathon = $this->getReference('hackathon_'.$hackathonID, Hackathon::class);
            $projet->setHackathon($hackathon);

            $this->addReference('projet_'.$i, $projet);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [HackathonFixtures::class];
    }
    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
