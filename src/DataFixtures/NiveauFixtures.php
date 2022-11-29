<?php

namespace App\DataFixtures;

use App\Factory\NiveauFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NiveauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        NiveauFactory::createOne(["libNiv"=>"M1"]);
        NiveauFactory::createOne(["libNiv"=>"M2"]);
    }
}
