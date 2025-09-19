<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HackathonFixtures extends Fixture
{
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
            $manager->persist($hackathon);
        }

        $manager->flush();
    }
}
