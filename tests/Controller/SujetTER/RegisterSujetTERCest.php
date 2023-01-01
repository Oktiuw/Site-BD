<?php

namespace App\Tests\Controller\SujetTER;

use App\Entity\GroupeEtudiants;
use App\Factory\EnseignantFactory;
use App\Factory\EtudiantFactory;
use App\Factory\GroupeEtudiantsFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

use function Zenstruck\Foundry\create;

class RegisterSujetTERCest
{
    public function Register(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $etudiant = EtudiantFactory::createOne(['cdUtil' => $user]);

        $niveau = NiveauFactory::createOne(['libNiv' => 'M1']);

        $etudiant->addGroupeEtudiant(GroupeEtudiantsFactory::createOne(['nomGroupe'=>'TD1',
                                                                        'niveau'=>$niveau])->object());

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => $niveau,
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter/1/register');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Votre sujet TER', 'h1');
    }

    public function EtudiantWithConditionsOnly(ControllerTester $I)
    {
    }
}
