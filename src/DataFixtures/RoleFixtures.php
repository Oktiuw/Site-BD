<?php

namespace App\DataFixtures;

use App\Factory\RolesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        RolesFactory::createOne(["libRole"=>"ROLE_ETUDIANT"]);
        RolesFactory::createOne(["libRole"=>"ROLE_ENSEIGNANT"]);
        RolesFactory::createOne(["libRole"=>"ROLE_ENTREPRISE"]);
    }
}
