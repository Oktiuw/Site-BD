<?php

namespace App\DataFixtures;

use App\Factory\TypeEvenementFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeEvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TypeEvenementFactory::createMany(20, function () {
            $tirage = rand(1, 10);
            $chaine= "MR".rand(100, 300);
            if ($tirage<=5) {
                $chaine.="-TD";
            } else {
                $chaine.="-TP";
            }
            return ["intTpEvmt"=>$chaine];
        });
    }
}
