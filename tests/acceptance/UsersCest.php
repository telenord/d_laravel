<?php


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
		$I->resetEmails();
        $I->amOnPage('/register');

		$I->fillField(self::inputRegisterName, 'Test user name');
		$I->fillField(self::inputRegisterEmail, 'test.user@example.com');
		$I->fillField(self::inputRegisterPassword, 'passw0RD');
		$I->fillField(self::inputRegisterConfirmPassword, 'passw0RD');
		$I->click(self::btnRegister);

		//redirects to email verification page
		$I->seeInCurrentUrl('/verification/email_not_verified');
		$I->see('Your email isn\'t verified.');
		$I->see('Please check your mail box and click the link sent to you in verification email.');
		$I->see('Test user name');
		
		//email received
		$I->seeEmailCount(1);
		$I->seeInLastEmailTo('test.user@example.com', 'Welcome to Time-Spotter');
		$I->seeInLastEmail('Please click here to verify your email address:');
		$I->seeInLastEmail('If you did not sign up to create a profile on Time-Spotter, please inform us by replying to this email. Thank you!');
		$I->seeInLastEmail('The Time-Spotter Team');
		
		//resend verification email
		$I->resetEmails();
		$I->click(['css' => '#anchorResendVerificationEmail']);
		$I->waitForText('Verification email is sent successfully. Please check your mail box', 3);
		
		//email received
		$I->seeEmailCount(1);
		$I->seeInLastEmailTo('test.user@example.com', 'Welcome to Time-Spotter');
		$I->seeInLastEmail('Please click here to verify your email address:');

		//get verification link from email
		$verificationLink = $I->grabMatchesFromLastEmail('@href="([^"]*)"@');
        $I->amOnUrl($verificationLink[1]);

		$I->seeInCurrentUrl('/home');
		$I->see('Test user name');
		$I->see('You are logged in!');
	}
	

	const btnLogin = ['css' => '#frmLogin #btnLogin'];
	const inputLoginEmail = ['css' => '#frmLogin input[type=email][name=email]'];
	const inputLoginPassword = ['css' => '#frmLogin input[type=password][name=password]'];


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
		$I->seeElement(self::inputLoginEmail);
		$I->seeElement(self::inputLoginPassword);
		$I->seeElement(self::btnLogin);
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
		$I->fillField(self::inputLoginEmail, '');
		$I->fillField(self::inputLoginPassword, '');
		$I->click(self::btnLogin);
		$I->see('The email field is required');
		$I->see('The password field is required');
    }
	
	/**
     * Test Login
     *
     * @return void
    public function testLogin()
    {
        $user = factory(App\Models\User::class)->create(['password' => Hash::make('passw0RD')]);
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('passw0RD', 'password')
            ->press('Login')
            ->seePageIs('/home')
            ->see($user->name);
    }
    */

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

    /**
     * Test home page works with Authenticated Users
     *
     * @return void
    public function testHomePageForAuthenticatedUsers()
    {
        $user = factory(App\Models\User::class)->create();
        $this->actingAs($user)
            ->visit('/home')
            ->see($user->name);
    }
     */
    /**
     * Test log out
     *
     * @return void
    public function testLogout()
    {
        $user = factory(App\Models\User::class)->create();
        $this->actingAs($user)
            ->visit('/logout')
            ->seePageIs('/');
    }
     */
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
    /**
     * Test send password reset
     *
     * @return void
    public function testSendPasswordReset()
    {
        $user = factory(App\Models\User::class)->create();
        $this->visit('password/reset')
            ->type($user->email, 'email')
            ->press('Send Password Reset Link')
            ->see('We have e-mailed your password reset link!');
    }
     */
    /**
     * Test send password reset user not exists
     *
     * @return void
    public function testSendPasswordResetUserNotExists()
    {
        $this->visit('password/reset')
            ->type('notexistingemail@gmail.com', 'email')
            ->press('Send Password Reset Link')
            ->see('We can\'t find a user with that e-mail address.');
    }
     */
}
