<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use App\Entity\Utilisateur;
use App\Factory\EtudiantFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EtudiantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $niveaux=$manager->getRepository(Niveau::class)->findAll();
        EtudiantFactory::createMany(50, function () use ($niveaux) {
            $lastname=EtudiantFactory::faker()->unique()->lastName();
            return ['niveau'=>$niveaux[array_rand($niveaux)],'nomEtud'=>"$lastname",'cdUtil'=>UtilisateurFactory::createOne(["roles"=>["ROLE_ETUDIANT"],"login"=>strtolower(str_replace(" ", "", "$lastname".rand(1, 300)))])];
        });
        EtudiantFactory::createOne(['niveau'=>$niveaux[0],'cdUtil'=>UtilisateurFactory::createOne(["login"=>"Etudiant","roles"=>["ROLE_ETUDIANT"]])]);
    }

    public function getDependencies()
    {
        return[UtilisateurFixtures::class];
    }
}
