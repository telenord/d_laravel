/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
*/


/*
defines 
$.TSPApp.User.resendVerificationEmail('{{ URL::route('verification.resend_verification_email') }}'); 
*/
$.TSPApp.User = function() {
	"use strict";

	var fnResendVerificationEmail = function(url) {
		$.TSPApp.Ajax.post(url);
	};

	return {
		resendVerificationEmail : fnResendVerificationEmail 
	};
}();
