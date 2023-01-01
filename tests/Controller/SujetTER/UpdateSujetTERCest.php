<?php

namespace App\Tests\Controller\SujetTER;

use App\Factory\EnseignantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

use Codeception\Util\HttpCode;

use function Zenstruck\Foundry\create;

class UpdateSujetTERCest
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
        $I->amOnPage('/sujetter/1/update');
        $I->seeResponseCodeIsSuccessful();

        $I->seeInTitle("Édition d'un sujet TER");
        $I->see("Édition d'un sujet TER", 'h1');
    }

    public function EnseignantOnly(ControllerTester $I)
    {
        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => NiveauFactory::createOne(['libNiv' => 'M1']),
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        $userEtud = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $I->amLoggedInAs($userEtud->object());
        $I->amOnPage('/sujetter/1/update');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);

        $userEnt = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($userEnt->object());
        $I->amOnPage('/sujetter/1/update');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
