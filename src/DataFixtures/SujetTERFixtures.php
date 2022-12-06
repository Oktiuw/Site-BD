<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Enseignant;
use App\Factory\EnseignantFactory;
use App\Factory\EtudiantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SujetTERFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        SujetTERFactory::createMany(10, function () {
            $niveau = NiveauFactory::random();
            $enseignant = EnseignantFactory::random();

            if (EtudiantFactory::faker()->boolean(20)) {
                $etudiant = EtudiantFactory::random();
            } else {
                $etudiant = null;
            }

            return [
                'niveau' => $niveau,
                'enseignant' => $enseignant,
                'etudiant' => $etudiant
            ];
        });
    }

    public function getDependencies()
    {
        return [
            NiveauFixtures::class,
            EnseignantFixtures::class,
            EtudiantFixtures::class,
        ];
    }
}
