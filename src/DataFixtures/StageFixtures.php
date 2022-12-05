<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Niveau;
use App\Factory\StageFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        # on récupère aléatoirement un niveau et une entreprise
        $entreprises = $manager->getRepository(Entreprise::class)->findAll();
        $niveaux = $manager->getRepository(Niveau::class)->findAll();

        StageFactory::createMany(50, function () use ($entreprises, $niveaux) {
            return [
                'entreprise' => $entreprises[array_rand($entreprises)],
                'niveau' => $niveaux[array_rand($niveaux)],
            ];
        });
    }

    public function getDependencies()
    {
        return[UtilisateurFixtures::class];
    }
}
