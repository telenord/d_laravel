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
