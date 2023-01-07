<?php

namespace App\Tests\Controller\Admin;

use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function adminOnly(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/admin');
        $I->seeResponseCodeIs(403);
    }
    public function adminOk(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ADMIN,ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($user->object());
        $I->amOnPage('/admin');
        $I->seeResponseCodeIs(200);
    }
}
