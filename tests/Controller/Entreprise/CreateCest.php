<?php

namespace App\Tests\Controller\Entreprise;

use App\Factory\EntrepriseFactory;
use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function form(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/create');
        $I->seeInTitle("Entreprise");
        $I->see("Création de Profile Entreprise", 'h1');
    }

}
