/*
 * This file is part of laravel-bootstrap-adminlte-starter-kit.
 *
 * Copyright (c) 2016 Oleksii Prudkyi
*/

/*
defines 
$.TSPApp.Notify.showSuccess('success'); 
$.TSPApp.Notify.showError('error'); 
 */
$.TSPApp.Notify = function() {
	"use strict";
	
	var fnShowSuccess = function(message) {
		if (typeof message === "undefined") {
			throw new Error("message is required");
		}
		$.notify({
			message: message 
			,icon : "fa fa-info-circle"
		},{
			type: 'info'
		});
	};

	var fnShowError = function(message) {
		if (typeof message === "undefined") {
			throw new Error("message is required");
		}
		$.notify({
			message: message 
			, icon: "fa fa-exclamation-triangle"
		},{
			type: 'warning'
			, delay : 0
		});
	};

	return {
		showSuccess : fnShowSuccess 
		, showError : fnShowError 
	};
}();

