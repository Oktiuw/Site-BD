<?php


namespace App\Tests\Controller\Stage;

use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function restriction(ControllerTester $I)
    {
        $I->amOnPage('/stage');
        $I->see('Identifiez-vous','h1');
    }
}
