<?php 
/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
 */ 

namespace Page\Acceptance;

class Login
{
    // include url of current page
    public static $URL = '/login';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
	public static $btnLogin = ['css' => '#frmLogin #btnLogin'];
	public static $inputLoginEmail = ['css' => '#frmLogin input[type=email][name=email]'];
	public static $inputLoginPassword = ['css' => '#frmLogin input[type=password][name=password]'];

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

	public function login($name, $password)
	{
		$I = $this->acceptanceTester;

		$I->amOnPage(self::$URL);
		$I->see('E-Mail Address');
		$I->see('Password');
		$I->see('Login');
		$I->seeElement(self::$inputLoginEmail);
		$I->seeElement(self::$inputLoginPassword);
		$I->seeElement(self::$btnLogin);

		$I->fillField(self::$inputLoginEmail, $name);
		$I->fillField(self::$inputLoginPassword, $password);
		$I->click(self::$btnLogin);

		return $this;
	}    
}
