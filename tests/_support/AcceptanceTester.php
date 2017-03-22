<?php
/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
 */


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTesterBase extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
}

class AcceptanceTester extends AcceptanceTesterBase
{
	public function amOnPage($page) 
	{
		parent::amOnPage($page);
		//$this->waitForJs('return document.readyState == "complete"', 10);
		$this->dontSeeJsErrors();
		$this->dontSeeImgErrors();
	}

	public function click($link, $context = null) 
	{
		parent::click($link, $context);
		$this->dontSeeJsErrors();
	}

	public function dontSeeJsErrors()
	{
		//check js errors
		$error = $this->grabAttributeFrom( "head", "data-jserror" );
		if(!is_null($error)) {
			$this->fail($error);
		}
	}

	public function dontSeeImgErrors()
	{
		//check img errors
		$error = $this->grabAttributeFrom( "head", "data-imgerror" );
		if(!is_null($error)) {
			$this->fail($error);
		}
	}

	/*
    public function waitAjaxLoad($timeout = 10)
    {
        $this->waitForJs('return !!window.jQuery && window.jQuery.active == 0;', $timeout);
        $this->wait(1);
        $this->dontSeeJsError();
    }
	*/

   /**
    * Define custom actions here
    */

	public static $applicationName = 'Starter-Kit app.name';
	public static $applicationDescription = 'Base functionality for other projects';
}
