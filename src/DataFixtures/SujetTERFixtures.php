<?php

namespace App\DataFixtures;

use App\Entity\Enseignant;
use App\Factory\EnseignantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SujetTERFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
        exit;
        SujetTERFactory::createMany(15, function () {
            $niveau_id = NiveauFactory::random();
            $enseignant_id = EnseignantFactory::random();

            return [
                'niveau_id' => $niveau_id,
                'enseignant_id' => $enseignant_id,
            ];
        });
    }

    public function getDependencies()
    {
        return [
            NiveauFactory::class,
            EnseignantFactory::class,
        ];
    }
}
