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







}