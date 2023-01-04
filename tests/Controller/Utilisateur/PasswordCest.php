<?php

namespace App\Tests\Controller\Utilisateur;

use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

class PasswordCest
{
    public function password(ControllerTester $I): void
    {
        $user = UtilisateurFactory::createOne(['roles' => ['IS_AUTHENTICATED_FULLY']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/updatePassword');
        $I->see("Modification de votre mot de passe", 'h1');
    }
}
