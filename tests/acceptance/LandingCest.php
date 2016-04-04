<?php


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
		$I->wantTo('Check if site running');
        $I->amOnPage('/');
		$I->see('Time-spotter');
		$I->cantSee('A tool to monitor your time');
		$I->resizeWindow(1024, 768);
		$I->scrollTo(['class' => 'main-footer']);
		$I->canSee('A tool to monitor your time');
		$I->seeInCurrentUrl('/');
	}
}
