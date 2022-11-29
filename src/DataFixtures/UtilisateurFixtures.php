<?php

namespace App\DataFixtures;

use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UtilisateurFactory::createMany(50, ["roles"=>["ROLE_ETUDIANT,ROLE_USER"]]);
        UtilisateurFactory::createMany(50, ["roles"=>["ROLE_ENTREPRISE,ROLE_USER"]]);
        UtilisateurFactory::createMany(10, ["roles"=>["ROLE_ENSEIGNANT,ROLE_USER"]]);
        UtilisateurFactory::createOne(["roles"=>["ROLE_ENSEIGNANT,ROLE_ADMIN"],"login"=>"root"]);
    }
}
