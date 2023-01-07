<?php

namespace App\Tests\Controller\Stage;

use App\Factory\EntrepriseFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function restriction(ControllerTester $I)
    {
        $I->amOnPage('/stage');
        $I->see('Identifiez-vous', 'h1');
    }
    public function addStage(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $entreprise=EntrepriseFactory::createOne(['cdUtil'=>$user]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/stage');
        $I->see('Ajouter un nouveau stage', 'a.btn-dark');
    }
}
