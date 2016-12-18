<?php 
/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
 */ ?>
<?php
/*
 * based on https://github.com/acacha/adminlte-laravel/blob/master/tests/AcachaAdminLTELaravelTest.php
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

use Step\Acceptance\Member as MemberTester;

/**
 * Class UsersTest
 */
class UsersTest extends TransactionsTestCase
{
	
    /**
     * Test Login Page
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->visit('/login')
			->see('E-Mail Address')
			->see('Password')
			->see('Login')
			;
    }
    /**
     * Test Login
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(App\Models\User::class)->create(['password' => Hash::make('passw0RD'), 'verified' => 1]);
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('passw0RD', 'password')
            ->press('Login')
            ->seePageIs('/home')
            ->see($user->name);
    }
    /**
     * Test Login
     *
     * @return void
     */
    public function testLoginRequiredFields()
    {
        $this->visit('/login')
            ->type('', 'email')
            ->type('', 'password')
            ->press('Login')
            ->see('The email field is required')
            ->see('The password field is required');
    }
    /**
     * Test Register Page
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $this->visit('/register')
			->see('Register')
			->see('Password')
			;
    }
    /**
     * Test Password reset Page
     *
     * @return void
     */
    public function testPasswordResetPage()
    {
        $this->visit('/password/reset')
			->see('Reset Password')
			->see('Send Password Reset Link')
			;
    }
    /**
     * Test home page is only for authorized Users
     *
     * @return void
     */
    public function testHomePageForUnauthenticatedUsers()
    {
        $this->visit('/home')
            ->seePageIs('/login');
    }
    /**
     * Test home page works with Authenticated Users
     *
     * @return void
     */
    public function testHomePageForAuthenticatedUsers()
    {
        $user = factory(App\Models\User::class)->create();
        $this->actingAs($user)
            ->visit('/home')
            ->see($user->name);
    }
    /**
     * Test log out
     *
     * @return void
     */
    public function testLogout()
    {
        $user = factory(App\Models\User::class)->create();
        $this->actingAs($user)
            ->visit('/logout')
            ->seePageIs('/');
    }
    /**
     * Test 404 Error page
     *
     * @return void
     */
    public function test404Page()
    {
        $this->get('asdasdjlapmnnk')
            ->seeStatusCode(404)
            ->see('Sorry, the page you are looking for could not be found.');
    }
    /**
     * Test user registration
     *
     * @return void
     */
    public function testNewUserRegistration()
    {
        $this->visit('/register')
            ->type(MemberTester::$username, 'name')
            ->type(MemberTester::$email, 'email')
//            ->check('terms') TODO
            ->type(MemberTester::$password, 'password')
            ->type(MemberTester::$password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/verification/email_not_verified')
            ->seeInDatabase('users', ['email' => MemberTester::$email,
                                      'name'  => MemberTester::$username]);
    }
    /**
     * Test required fields on registration page
     *
     * @return void
     */
    public function testRequiredFieldsOnRegistrationPage()
    {
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required')
            ->see('The email field is required')
            ->see('The password field is required');
    }
    /**
     * Test send password reset
     *
     * @return void
     */
    public function testSendPasswordReset()
    {
        $user = factory(App\Models\User::class)->create();
        $this->visit('password/reset')
            ->type($user->email, 'email')
            ->press('Send Password Reset Link')
            ->see('We have e-mailed your password reset link!');
    }
    /**
     * Test send password reset user not exists
     *
     * @return void
     */
    public function testSendPasswordResetUserNotExists()
    {
        $this->visit('password/reset')
            ->type('notexistingemail@gmail.com', 'email')
            ->press('Send Password Reset Link')
            ->see('We can\'t find a user with that e-mail address.');
    }
}