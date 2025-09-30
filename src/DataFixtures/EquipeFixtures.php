<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture implements DependentFixtureInterface,FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $equipe = new Equipe();
            $equipe->setNom('Tyn1');
            $equipe->setLienPrototype('https://google.com');
            $manager->persist($equipe);

            $projetID = rand(1, ProjetFixtures::NB_PROJ - 1);
            $projet = $this->getReference('projet_'.$projetID, Projet::class);
            $equipe->setProjet($projet);

            $this->addReference('equipe_'.$i, $equipe);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [ProjetFixtures::class];
    }
}
