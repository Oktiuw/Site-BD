<?php

namespace App\Tests\Controller\Entreprise;


use App\Factory\EntrepriseFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function form(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);

        EntrepriseFactory::createOne([
            'nomRef' => 'Jean Jean',
            'nomEnt' => 'SARL Jean',
            'cdUtil' => $user,
            'telEnt' => null,
            'isDisabled' => false,

        ]);

        $I->amLoggedInAs($user->object());
        $I->amOnPage('/entreprise/1/update');

    }


}
