<?php


class UsersCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
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
    public function test404Page()
    {
        $this->get('asdasdjlapmnnk')
            ->seeStatusCode(404)
            ->see('404');
    }
     */
    /**
     * Test user registration
     *
     * @return void
    public function testNewUserRegistration()
    {
        $this->visit('/register')
            ->type('Sergi Tur Badenas', 'name')
            ->type('sergiturbadenas@gmail.com', 'email')
//            ->check('terms') TODO
            ->type('passw0RD', 'password')
            ->type('passw0RD', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/home')
            ->seeInDatabase('users', ['email' => 'sergiturbadenas@gmail.com',
                                      'name'  => 'Sergi Tur Badenas']);
    }
     */
    /**
     * Test required fields on registration page
     *
     * @return void
    public function testRequiredFieldsOnRegistrationPage()
    {
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required')
            ->see('The email field is required')
            ->see('The password field is required');
    }
     */
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
