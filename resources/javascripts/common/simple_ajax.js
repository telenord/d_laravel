/*
defines 
$.TSPApp.Ajax.post(url); 
expects url and returned json with fields:
status: success/fail/error
message: success/fail message
 */
$.TSPApp.Ajax = function() {
	"use strict";
	
	var fnPost = function(url) {
		if (typeof url === "undefined") {
			throw new Error("Url is required");
		}

		$.post(url).done(function(data) {
				if(typeof data.status === 'undefined') {
					throw new Error("Incorrect ajax result, status field is required");
				}
				if(data.status != 'success') {
					if(typeof data.message === 'undefined') {
						throw new Error("Incorrect ajax result, message field is required");
					}
					$.TSPApp.Notify.showError(data.message);
				} else {
					//if message set - show it 
					if(typeof data.message !== 'undefined') {
						$.TSPApp.Notify.showSuccess(data.message); 
					}
				}
			}).fail(function( jqXHR, textStatus, errorThrown) {
				var errorMessage = "Error on calling : " + url + "<br/>" +
					(typeof errorThrown === 'undefined' ? textStatus : errorThrown);
				$.TSPApp.Notify.showError(errorMessage);
			});
	};

	return {
		post : fnPost 
	};
}();


