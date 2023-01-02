<?php


namespace App\Tests\Controller\SujetTER;

use App\Factory\EnseignantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class CreateSujetTERCest
{
    public function form(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);

        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter/create');
        $I->seeResponseCodeIsSuccessful();

        $I->seeInTitle('Ajouter un sujet TER');
        $I->see('Ajouter un sujet TER', 'h1');
    }

    public function EnseignantOnly(ControllerTester $I)
    {
        #acces refusé pour les Etudiant
        $userEtud = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $I->amLoggedInAs($userEtud->object());
        $I->amOnPage('/sujetter/create');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);

        #acces refusé pour les Entreprise
        $userEnt = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($userEnt->object());
        $I->amOnPage('/sujetter/create');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
