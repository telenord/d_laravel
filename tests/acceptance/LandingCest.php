<?php 
/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
 */


class LandingCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function checkLandingPage(AcceptanceTester $I)
    {
		$I->wantTo('Check if landing page visible');
        $I->amOnPage('/');
		$I->see(AcceptanceTester::$applicationName);
		$I->cantSee(AcceptanceTester::$applicationDescription);
		$I->resizeWindow(1024, 768);
		$I->scrollTo(['class' => 'main-footer']);
		$I->canSee(AcceptanceTester::$applicationDescription);
		$I->seeInCurrentUrl('/');
	}
}
