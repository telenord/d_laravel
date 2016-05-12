<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
	
if (!App::environment('production')) {
	Route::get('adminlte_demo', function () {
		return view('adminlte_demo');
	});

	Route::get('app_demo', function () {
		return view('layouts/app');
	});
}

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::auth();

	//email verification 
	Route::get('verification/email_not_verified', ['as'=> 'verification.email_not_verified', 'uses' => 'Auth\EmailVerificationController@emailNotVerified']);
	Route::any('verification/resend_verification_email', ['as'=> 'verification.resend_verification_email', 'uses' => 'Auth\EmailVerificationController@resendVerificationEmail']);
    Route::get('verification/error', 'Auth\AuthController@getVerificationError');
    Route::get('verification/{token}', 'Auth\AuthController@getVerification');


    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@indexPublic');
});
