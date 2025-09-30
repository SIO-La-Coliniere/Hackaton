<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\Organisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HackathonFixtures extends Fixture implements DependentFixtureInterface,FixtureGroupInterface
{
    public const NB_HACK = 3;
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; ++$i) {
            $hackathon = new Hackathon();

            $start = (new \DateTime('2025-09-19 14:00:00'))->add(new \DateInterval('PT' . ($i * 60) . 'H'));
            $end = (new \DateTime('2025-09-19 16:00:00'))->add(new \DateInterval('PT' . ($i * 60) . 'H'));

            $hackathon->setDateHeureDebut($start);
            $hackathon->setDateHeureFin($end);
            $hackathon->setLieu('La Coliniere');
            $hackathon->setVille('Nantes');
            $hackathon->setTheme('Developpement');

            $organisateurID = random_int(0, OrganisateurFixtures::NB_ORGA - 1);
            $organisateur = $this->getReference('organisateur_' . $organisateurID, Organisateur::class);
            $hackathon->setOrganisateur($organisateur);
            $manager->persist($hackathon);

            $this->addReference('hackathon_'.$i, $hackathon);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [OrganisateurFixtures::class];
    }
    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['done'];
    }
}
