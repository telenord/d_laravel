<?php 
/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
 */ ?>
<?php

use Step\Acceptance\Member as MemberTester;

class UsersCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }
	
	const btnRegister = ['css' => '#frmRegister #btnRegister'];
	const inputRegisterName = ['css' => '#frmRegister input[type=text][name=name]'];
	const inputRegisterEmail = ['css' => '#frmRegister input[type=email][name=email]'];
	const inputRegisterPassword = ['css' => '#frmRegister input[type=password][name=password]'];
	const inputRegisterConfirmPassword = ['css' => '#frmRegister input[type=password][name=password_confirmation]'];
	
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
		$I->seeElement(self::btnRegister);
		$I->seeElement(self::inputRegisterName);
		$I->seeElement(self::inputRegisterEmail);
		$I->seeElement(self::inputRegisterPassword);
		$I->seeElement(self::inputRegisterConfirmPassword);
    }
	
	public function testRegisterPageRequiredFields(AcceptanceTester $I)
    {
		$I->wantTo('Check if required fields at register page works');
        $I->amOnPage('/register');

		$I->fillField(self::inputRegisterName, '');
		$I->fillField(self::inputRegisterEmail, '');
		$I->fillField(self::inputRegisterPassword, '');
		$I->fillField(self::inputRegisterConfirmPassword, '');
		$I->click(self::btnRegister);
		$I->see('The name field is required');
		$I->see('The email field is required');
		$I->see('The password field is required');
    }

	/**
     * Test user registration
     *
     * @return void
     */
    public function testNewUserRegistration(AcceptanceTester $I)
    {
		$I->wantTo('Check if register page works');
		$I->resizeWindow(1024, 768);
		$I->resetEmails();
        $I->amOnPage('/register');

		$I->fillField(self::inputRegisterName, MemberTester::$username);
		$I->fillField(self::inputRegisterEmail, MemberTester::$email);
		$I->fillField(self::inputRegisterPassword, MemberTester::$password);
		$I->fillField(self::inputRegisterConfirmPassword, MemberTester::$password);
		$I->click(self::btnRegister);

		//redirects to email verification page
		$I->seeInCurrentUrl('/verification/email_not_verified');
		$I->see('Your email isn\'t verified.');
		$I->see('Please check your mail box and click the link sent to you in verification email.');
		$I->see(MemberTester::$username);
		
		//email received
		$I->seeEmailCount(1);
		$I->seeInLastEmailTo(MemberTester::$email, 'Welcome to ' . AcceptanceTester::$applicationName);
		$I->seeInLastEmail('Please click here to verify your email address:');
		$I->seeInLastEmail('If you did not sign up to create a profile on ' . AcceptanceTester::$applicationName . ', please inform us by replying to this email. Thank you!');
		$I->seeInLastEmail('The ' . AcceptanceTester::$applicationName . ' Team');
		
		//resend verification email
		$I->resetEmails();
		$I->click(['css' => '#anchorResendVerificationEmail']);
		$I->waitForText('Verification email is sent successfully. Please check your mail box', 3);
		
		//email received
		$I->seeEmailCount(1);
		$I->seeInLastEmailTo(MemberTester::$email, 'Welcome to ' . AcceptanceTester::$applicationName);
		$I->seeInLastEmail('Please click here to verify your email address:');

		//get verification link from email
		$verificationLink = $I->grabMatchesFromLastEmail('@href="([^"]*)"@');
        $I->amOnUrl($verificationLink[1]);

		$I->seeInCurrentUrl('/home');
		$I->see(MemberTester::$username);
		$I->see('You are logged in!');
	}
	
	
	/**
     * Test Login
     *
     * @return void
     */
    public function testLoginRequiredFields(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
		$I->wantTo('Check if required fields at login page works');
		$loginPage->login('', '');
		$I->see('The email field is required');
		$I->see('The password field is required');
    }
	
	public function testLoginLogout(MemberTester $I, \Page\Acceptance\Login $loginPage)
    {
		$I->wantTo('Check if user can login/logout');
		$I->loginAsUser($loginPage);
		$I->seeInCurrentUrl('/home');
		$I->see(MemberTester::$username);
		$I->see('You are logged in!');
        $I->amOnPage('/logout');
		$I->seeInCurrentUrl('/');
    }
	
	const btnReset = ['css' => '#frmReset #btnReset'];
	const inputResetEmail = ['css' => '#frmReset input[type=email][name=email]'];
	const inputResetPassword = ['css' => '#frmReset input[type=password][name=password]'];
	const inputResetConfirmPassword = ['css' => '#frmReset input[type=password][name=password_confirmation]'];

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
		$I->seeElement(self::btnReset);
		$I->seeElement(self::inputResetEmail);
    }
	
    /**
     * Test password reset page visible
     *
     * @return void
     */
	public function testSendPasswordResetUserNotExists(AcceptanceTester $I)
    {
		$I->wantTo('Check if send password reset user not exists');
        $I->amOnPage('/password/reset');
		$I->fillField(self::inputResetEmail, 'notexistingemail@example.com');
		$I->click(self::btnReset);
		$I->see('We can\'t find a user with that e-mail address.');
    }
	
	/**
     * Test send password reset
     *
     * @return void
     */
	public function testSendPasswordReset(AcceptanceTester $I)
    {
		$I->wantTo('Check if send password reset works');
		$I->resetEmails();
        $I->amOnPage('/password/reset');
		$I->fillField(self::inputResetEmail, MemberTester::$email);
		$I->click(self::btnReset);
		$I->waitForText('We have e-mailed your password reset link!');
		
		//email received
		$I->seeEmailCount(1);
		$I->seeInLastEmailTo(MemberTester::$email, 'Reset Password');
		$I->seeInLastEmail('You are receiving this email because we received a password reset request for your account');
		$I->seeInLastEmail('If you did not request a password reset, no further action is required.');
		$I->seeInLastEmail(AcceptanceTester::$applicationName);

		//get verification link from email
		$verificationLink = $I->grabMatchesFromLastEmail('@<a href="([^"]*)"@');
        $I->amOnUrl($verificationLink[1]);

		$I->seeInCurrentUrl('/password/reset');
		$I->see('Reset password for ' . AcceptanceTester::$applicationName);
		
		$I->fillField(self::inputResetEmail, MemberTester::$email);
		$I->fillField(self::inputResetPassword, MemberTester::$password);
		$I->fillField(self::inputResetConfirmPassword, MemberTester::$password);
		$I->click(self::btnReset);
		$I->see(MemberTester::$username);
		$I->see('You are logged in!');
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

    /**
     * Test 404 Error page
     *
     * @return void
     */
    public function test404Page(AcceptanceTester $I)
    {
		$I->wantTo('Check if 404 works');
        $I->amOnPage('/asdasdjlapmnnk');
		$I->see('Sorry, the page you are looking for could not be found.');
    }
}