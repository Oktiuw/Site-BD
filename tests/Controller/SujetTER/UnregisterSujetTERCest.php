<?php

namespace App\Tests\Controller\SujetTER;

use App\Factory\EnseignantFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class UnregisterSujetTERCest
{
    public function EtudiantOnly(ControllerTester $I)
    {
        $niveau1 = NiveauFactory::createOne(['libNiv' => 'M1']);

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => $niveau1,
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        #acces refusé pour les Enseignants
        $userEns = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($userEns->object());
        $I->amOnPage('/sujetter/1/unregister');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);

        #acces refusé pour les Entreprises
        $userEnt = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($userEnt->object());
        $I->amOnPage('/sujetter/1/unregister');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
