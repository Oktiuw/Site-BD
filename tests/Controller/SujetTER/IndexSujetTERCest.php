<?php


namespace App\Tests\Controller\SujetTER;

use App\Tests\Support\ControllerTester;
use App\Factory\UtilisateurFactory;


class IndexSujetTERCest
{
    public function OnPageSujetTerForEtudiant(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Liste des Sujets TER', 'h1');
    }
    public function OnPageSujetTerForEnseignant(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Liste des Sujets TER', 'h1');
    }
}
