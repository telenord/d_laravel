<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
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


Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');

//email verification 
Route::get('verification/email_not_verified', ['as'=> 'verification.email_not_verified', 'uses' => 'Auth\EmailVerificationController@emailNotVerified']);
Route::any('verification/resend_verification_email', ['as'=> 'verification.resend_verification_email', 'uses' => 'Auth\EmailVerificationController@resendVerificationEmail']);
Route::get('verification/error', 'Auth\AuthController@getVerificationError');
Route::get('verification/{token}', 'Auth\AuthController@getVerification');


Route::get('/home', ['as'=> 'user.home', 'uses' => 'HomeController@index']);
Route::get('/', 'HomeController@indexPublic');
