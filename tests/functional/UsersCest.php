<?php
/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
*/

/*
 * based on https://github.com/acacha/adminlte-laravel/blob/master/tests/AcachaAdminLTELaravelTest.php
 * and ported to Codeception format
 */


use App\Models\User;
use Step\Acceptance\Member as MemberTester;

class UsersCest
{
    /**
     * Test Login Page
     *
     * @return void
     */
    public function testLoginPage(FunctionalTester $I)
    {
		$I->amOnPage('/login');
		$I->see('E-Mail Address');
		$I->see('Password');
		$I->see('Login');
    }
	
	const BTN_LOGIN = ['css' => '#frmLogin #btnLogin'];

    /**
     * Test Login
     *
     * @return void
     */
    public function testLoginLogout(FunctionalTester $I)
    {
		$user = factory(User::class)->create(['password' => Hash::make('passw0RD'), 'verified' => 1]);
		$I->amOnPage('/login');
		$I->fillField('email', $user->email);
		$I->fillField('password', 'passw0RD');
		$I->click(self::BTN_LOGIN);
		$I->seeCurrentUrlEquals('/home');
		$I->see($user->name);

		$I->seeRecord('users', ['email' => $user->email]);
		$I->seeAuthentication();

		$I->amOnPage('/logout');
		$I->seeCurrentUrlEquals('/');
    }

    /**
     * Test Login
     *
     * @return void
     */
    public function testLoginRequiredFields(FunctionalTester $I)
    {
		$I->amOnPage('/login');
		$I->fillField('email', '');
		$I->fillField('password', '');
		$I->click(self::BTN_LOGIN);
		$I->see('The email field is required');
		$I->see('The password field is required');
    }

    /**
     * Test Register Page
     *
     * @return void
     */
    public function testRegisterPage(FunctionalTester $I)
    {
		$I->amOnPage('/register');
		$I->see('Register');
		$I->see('Password');
    }

    /**
     * Test Password reset Page
     *
     * @return void
     */
    public function testPasswordResetPage(FunctionalTester $I)
    {
		$I->amOnPage('/password/reset');
		$I->see('Reset Password');
		$I->see('Send Password Reset Link');
    }

    /**
     * Test home page is only for authorized Users
     *
     * @return void
     */
    public function testHomePageForUnauthenticatedUsers(FunctionalTester $I)
    {
		$I->amOnPage('/home');
		$I->seeCurrentUrlEquals('/login');
    }
	
	/**
     * Test log out
     *
     * @return void
	 */
    public function testLogout(FunctionalTester $I)
    {
        $user = factory(App\Models\User::class)->create();
		$I->amLoggedAs($user);
		$I->amOnPage('/logout');
		$I->seeCurrentUrlEquals('/');
    }

    /**
     * Test 404 Error page
     *
     * @return void
     */
    public function test404Page(FunctionalTester $I)
    {
		$I->enableExceptionHandling();
		$I->amOnPage('/asdasdjlapmnnk');
		$I->seePageNotFound();
		$I->seeResponseCodeIs(404);
		$I->see('Sorry, the page you are looking for could not be found.');
    }

	const BTN_REGISTER = ['css' => '#frmRegister #btnRegister'];

    /**
     * Test user registration
     *
     * @return void
     */
    public function testNewUserRegistration(FunctionalTester $I)
    {
		$I->amOnPage('/register');
		$I->fillField('name', MemberTester::$username);
		$I->fillField('email', MemberTester::$email);
		$I->fillField('password', MemberTester::$password);
		$I->fillField('password_confirmation', MemberTester::$password);
		$I->click(self::BTN_REGISTER);
		$I->seeCurrentUrlEquals('/verification/email_not_verified');

		$I->seeRecord('users', [
			'email' => MemberTester::$email,
			'name'  => MemberTester::$username,
		]);
    }

    /**
     * Test required fields on registration page
     *
     * @return void
     */
    public function testRequiredFieldsOnRegistrationPage(FunctionalTester $I)
    {
		$I->amOnPage('/register');
		$I->click(self::BTN_REGISTER);
		$I->see('The name field is required');
		$I->see('The email field is required');
		$I->see('The password field is required');
    }

	const BTN_RESET = ['css' => '#frmReset #btnReset'];
    /**
     * Test send password reset
     *
     * @return void
     */
    public function testSendPasswordReset(FunctionalTester $I)
    {
		$user = factory(App\Models\User::class)->create();
		$I->amOnPage('/password/reset');
		$I->fillField('email', $user->email);
		$I->click(self::BTN_RESET);
		$I->see('We have e-mailed your password reset link!');
    }

    /**
     * Test send password reset user not exists
     *
     * @return void
     */
    public function testSendPasswordResetUserNotExists(FunctionalTester $I)
    {
		$I->amOnPage('/password/reset');
		$I->fillField('email', 'notexistingemail@gmail.com');
		$I->click(self::BTN_RESET);
		$I->see('We can\'t find a user with that e-mail address.');
    }
}
