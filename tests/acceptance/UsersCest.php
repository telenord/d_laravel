<?php


class UsersCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

	/**
     * Test Login Page
     *
     * @return void
     */
    public function testLoginPage(AcceptanceTester $I)
    {
		$I->wantTo('Check if login page visible');
        $I->amOnPage('/login');
		$I->see('E-Mail Address');
		$I->see('Password');
		$I->see('Login');
		$I->seeElement(['css' => 'form button[type=submit]']);
    }
	
	/**
     * Test Login
     *
     * @return void
     */
    public function testLoginRequiredFields(AcceptanceTester $I)
    {
		$I->wantTo('Check if required fields at login page works');
        $I->amOnPage('/login');
		$I->fillField(['name' => 'email'], '');
		$I->fillField(['name' => 'password'], '');
		$I->click('form button[type=submit]');
		$I->see('The email field is required');
		$I->see('The password field is required');
    }
	
	/**
     * Test Register Page
     *
     * @return void
     */
    public function testRegisterPage(AcceptanceTester $I)
    {
		$I->wantTo('Check if register page visible');
        $I->amOnPage('/register');
		$I->see('Name');
		$I->see('E-Mail Address');
		$I->see('Password');
		$I->see('Register');
		$I->seeElement(['css' => 'form button[type=submit]']);
    }

    /**
     * Test Password reset Page
     *
     * @return void
     */
    public function testPasswordResetPage(AcceptanceTester $I)
    {
		$I->wantTo('Check if password reset page visible');
        $I->amOnPage('/password/reset');
		$I->see('Reset Password');
		$I->see('E-Mail Address');
		$I->see('Send Password Reset Link');
		$I->seeElement(['css' => 'form button[type=submit]']);
    }
	
	/**
     * Test home page is only for authorized Users
     *
     * @return void
     */
    public function testHomePageForUnauthenticatedUsers(AcceptanceTester $I)
    {
		$I->wantTo('Check if home page is only for authorized Users');
        $I->amOnPage('/home');
		$I->seeInCurrentUrl('/login');
    }
}
