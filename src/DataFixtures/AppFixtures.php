<?php

namespace App\DataFixtures;

use App\Entity\Creation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $creation = new Creation;
            $creation->setTitle('creation ' . $i);
            $creation->setImage('creation image ' . $i);
            $creation->setAlt('creation image ' . $i);
            $creation->setBody('Test de cration : ' . $i);
            $manager->persist($creation);
        }

        $manager->flush();
    }
}
