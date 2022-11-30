<?php

namespace App\DataFixtures;

use App\Entity\Enseignant;
use App\Factory\EnseignantFactory;
use App\Factory\EtudiantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SujetTERFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SujetTERFactory::createMany(10, function () {
            $niveau_id = NiveauFactory::random();
            $enseignant_id = EnseignantFactory::random();

            if (EtudiantFactory::faker()->boolean(20)) {
                $etudiant_id = EtudiantFactory::random();
            } else {
                $etudiant_id = null;
            }


            return [
                'niveau_id' => $niveau_id,
                'enseignant_id' => $enseignant_id,
                'etudiant_id' => $etudiant_id,
            ];
        });
    }

    public function getDependencies()
    {
        return [
            NiveauFixtures::class,
            EnseignantFixtures::class,
            EtudiantFixtures::class
        ];
    }
}
