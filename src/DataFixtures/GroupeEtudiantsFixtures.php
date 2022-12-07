<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\GroupeEtudiants;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GroupeEtudiantsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        # on récupère tous les étudiants et les niveaux
        $etudiants = $manager->getRepository(Etudiant::class)->findAll();
        $niveaux = $manager->getRepository(Niveau::class)->findAll();

        # on crée des groupes d'étudiants en utilisant un niveau et des étudiants aléatoires
        foreach ($niveaux as $niveau) {
            $groupe = new GroupeEtudiants();
            $groupe->setNomGroupe('test');
            $groupe->setNiveau($niveau);
            shuffle($etudiants);
            for ($i = 0; $i < rand(1, count($etudiants)); $i++) {
                $groupe->addEtudiant($etudiants[$i]);
            }
            $manager->persist($groupe);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UtilisateurFixtures::class, # on dépend des données de l'entité Utilisateur
            NiveauFixtures::class, # on dépend des données de l'entité Niveau
        ];
    }
}
