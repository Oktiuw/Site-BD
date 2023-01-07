<?php

namespace App\Tests\Controller\Entreprise;

use App\Factory\EntrepriseFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function seeH1(ControllerTester $I): void
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/entreprise');
        $I->see('nomEnt', 'h1');
    }

    public function testRestriction(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise');
        #On voit si on est bien redirigé vers redircteur
        $I->seeResponseCodeIs(200);
    }
    public function testRestrictionOtherRoles(ControllerTester $I): void
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/entreprise');
        $I->seeResponseCodeIs(403);
    }

    public function contactEtudiant(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        EntrepriseFactory::createOne([
            'nomRef' => 'Jean Jean',
            'nomEnt' => 'SARL Jean',
            'cdUtil' => $user,
            'telEnt' => null,
            'isDisabled' => false,
        ]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/contact/etudiant');
        $I->seeInTitle("Contact");
        $I->see('Envoi de mail', 'h1');
    }

    public function contactGroupe(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        EntrepriseFactory::createOne([
            'nomRef' => 'Jean Jean',
            'nomEnt' => 'SARL Jean',
            'cdUtil' => $user,
            'telEnt' => null,
            'isDisabled' => false,
        ]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/contact/groupeEtudiants');
        $I->seeInTitle("Contact");
        $I->see('Envoi de mail', 'h1');
    }

    public function contactEnseignant(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        EntrepriseFactory::createOne([
            'nomRef' => 'Jean Jean',
            'nomEnt' => 'SARL Jean',
            'cdUtil' => $user,
            'telEnt' => null,
            'isDisabled' => false,
        ]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/contact/enseignant');
        $I->seeInTitle("Contact");
        $I->see('Envoi de mail', 'h1');
    }

    public function contactEntreprise(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        EntrepriseFactory::createOne([
            'nomRef' => 'Jean Jean',
            'nomEnt' => 'SARL Jean',
            'cdUtil' => $user,
            'telEnt' => null,
            'isDisabled' => false,
        ]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/contact/entreprise');
        $I->seeInTitle("Contact");
        $I->see('Envoi de mail', 'h1');
    }
}
