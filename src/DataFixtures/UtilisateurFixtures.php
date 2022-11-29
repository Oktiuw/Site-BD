<?php

namespace App\DataFixtures;

use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UtilisateurFactory::createMany(50, []);
        UtilisateurFactory::createMany(50, []);
        UtilisateurFactory::createMany(50, []);
    }
}
