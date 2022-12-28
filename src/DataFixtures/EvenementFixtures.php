<?php

namespace App\DataFixtures;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\GroupeEtudiants;
use App\Entity\TypeEvenement;
use App\Entity\Utilisateur;
use App\Factory\EvenementFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $etudiants=$manager->getRepository(GroupeEtudiants::class)->findAll();
        $enseignants=$manager->getRepository(Enseignant::class);
        $users=$manager->getRepository(Utilisateur::class);
        $typeEvmts=$manager->getRepository(TypeEvenement::class)->findAll();
        $enseignant=$enseignants->findOneBy(['cdUtil'=>$users->findOneBy(['login'=>'Enseignant'])]);
        for ($i=2;$i<=5;$i++) {
            EvenementFactory::createOne(['hDeb'=>EvenementFactory::faker()->dateTime()->setTime($i*3, '0'),'hFin'=>EvenementFactory::faker()->dateTime()->setTime(($i*3)+2, '0'),'typeEvenement'=>$typeEvmts[array_rand((array)$typeEvmts)],'enseignant'=>$enseignant,'groupeEtudiants'=>$etudiants]);
        }
    }

    public function getDependencies(): array
    {
        return [
            GroupeEtudiantsFixtures::class,
            NiveauFixtures::class,
            TypeEvenementFixtures::class,
            EnseignantFixtures::class
        ];
    }
}
