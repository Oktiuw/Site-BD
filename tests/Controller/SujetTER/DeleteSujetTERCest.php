<?php

namespace App\Tests\Controller\SujetTER;

use App\Factory\EnseignantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class DeleteSujetTERCest
{
    public function form(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => NiveauFactory::createOne(['libNiv' => 'M1']),
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => $user]),
            'etudiant' => null
        ]);

        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter/1/delete');
        $I->seeResponseCodeIsSuccessful();
        #utilisation de fenetre modal donc on reste sur la page index (liste des sujet Ter)
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Liste des Sujets TER', 'h1');
    }

    public function EnseignantOwnerOnly(ControllerTester $I)
    {
        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => NiveauFactory::createOne(['libNiv' => 'M1']),
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        #acces refusé pour les Etudiant
        $userEtud = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $I->amLoggedInAs($userEtud->object());
        $I->amOnPage('/sujetter/1/delete');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);

        #acces refusé pour les Entreprise
        $userEnt = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($userEnt->object());
        $I->amOnPage('/sujetter/1/delete');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);

        #acces refusé par le serveur pour les Enseignant qui ne sont pas responsable du sujet en question
        $userEns = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($userEns->object());
        $I->amOnPage('/sujetter/1/delete');
        $I->seeResponseCodeIs(HttpCode::INTERNAL_SERVER_ERROR);
    }
}
