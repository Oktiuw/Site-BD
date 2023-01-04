<?php

namespace App\Tests\Controller\SujetTER;

use App\Tests\Support\ControllerTester;
use App\Factory\UtilisateurFactory;
use Codeception\Util\HttpCode;

class IndexSujetTERCest
{
    public function AccessForEtudiant(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Liste des Sujets TER', 'h1');
    }
    public function AccessForEnseignant(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Liste des Sujets TER', 'h1');
    }

    public function NoAccessForEntreprise(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
