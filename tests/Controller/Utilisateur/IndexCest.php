<?php

namespace App\Tests\Controller\Utilisateur;

use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function avatar(ControllerTester $I): void
    {
        $user = UtilisateurFactory::createOne(['roles' => ['IS_AUTHENTICATED_FULLY']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/updateAvatar');
        $I->seeInTitle("Modification avatar");
        $I->see("Modification de votre avatar", 'h1');
    }





}
