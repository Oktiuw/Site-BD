<?php

namespace App\DataFixtures;

use App\Factory\EnseignantFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EnseignantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EnseignantFactory::createMany(5,function ()
        {
            $lastname=EnseignantFactory::faker()->unique()->lastName();
            return ['nomEtud'=>"$lastname",'cdUtil'=>UtilisateurFactory::createOne(["roles"=>["ROLE_ENSEIGNANT"],"login"=>strtolower(str_replace(" ","","$lastname".rand(1,300)))])];
        });
        EnseignantFactory::createOne((array)UtilisateurFactory::createOne(["roles" => ["ROLE_ENSEIGNANT"], "login" => "Enseignant"]));
        EnseignantFactory::createOne((array)UtilisateurFactory::createOne(["roles" => ["ROLE_ADMIN,ROLE_ENSEIGNANT"], "login" => "EnseignantAdmin"]));
    }
}
