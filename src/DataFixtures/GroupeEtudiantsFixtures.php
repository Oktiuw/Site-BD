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
        $groupe = new GroupeEtudiants();
        $groupe->setNomGroupe('CMM1');
        $groupe2 = new GroupeEtudiants();
        $groupe2->setNomGroupe('CMM2');
        $groupe->setNiveau($niveaux[0]);
        $groupe2->setNiveau($niveaux[1]);
        shuffle($etudiants);
        $compteur=0;
        foreach ($etudiants as $etudiant) {
            $compteur+=1;
            if ($compteur>=count($etudiants)/2) {
                $groupe2->addEtudiant($etudiant);
            } else {
                $groupe->addEtudiant($etudiant);
            }
        }
        $manager->persist($groupe);
        $manager->persist($groupe2);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EtudiantFixtures::class, # on dépend des données de l'entité Utilisateur
            NiveauFixtures::class, # on dépend des données de l'entité Niveau
        ];
    }
}
