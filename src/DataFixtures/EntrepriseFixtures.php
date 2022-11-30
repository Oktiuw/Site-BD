<?php

namespace App\DataFixtures;

use App\Factory\EntrepriseFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EntrepriseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EntrepriseFactory::createOne([
            'cdUtil' => UtilisateurFactory::createOne(["login"=>"Entreprise", "roles" => ["ROLE_ENTREPRISE"]])]);
        EntrepriseFactory::createMany(25, function () {
            $nomEnt = EntrepriseFactory::faker()->unique()->company();
            return ['nomEnt' => "$nomEnt", 'cdUtil' => UtilisateurFactory::createOne(["roles" => ["ROLE_ENTREPRISE"], "login" => strtolower(str_replace(" ", "", "$nomEnt" . rand(1, 300)))])];
        });
    }
}
