/*
   Modify jquery to catch exceptions
   Based on :
		https://github.com/rollbar/rollbar.js/blob/master/src/plugins/jquery.js
		https://gist.github.com/ndbroadbent/5097601
		https://github.com/airbrake/airbrake-js/blob/master/dist/instrumentation/jquery.js
   MIT licensed
*/

(function(jQuery, window, document) {
	
	"use strict";

	var logException = function(e) {
		showUncaughtException("Uncaught exception, check console logs for details :\n" + e.message);
		if(typeof console !== 'undefined' && typeof console.log !== 'undefined') {
			console.log(e);
		}
		//forward further
		throw e;
	};

	jQuery(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
		var status = jqXHR.status;
		var url = ajaxSettings.url;
		var type = ajaxSettings.type;

		// If status === 0 it means the user left the page before the ajax event finished
		// or other uninteresting events.
		if (!status) {
			return;
		}
		
		showUncaughtException("ajax error :\n" +
				(thrownError ? "thrownError : " + thrownError + "\n" : "") +
				"status : " + status + "\n" +
				"url : " + url + "\n" +
				"type : " + type + "\n" +
				"data : " + ajaxSettings.data + "\n" +
				"jqXHR_responseText : " + jqXHR.responseText + "\n" +
				"jqXHR_statusText : " + jqXHR.statusText
				);
	});

	// Wraps functions passed into jQuery's ready() with try/catch to
	// report errors to Rollbar
	/*
	var origReady = jQuery.fn.ready;
	jQuery.fn.ready = function(fn) {
		return origReady.call(this, function($) {
			try {
				fn($);
			} catch (e) {
				logException(e);
			}
		});
	};
	*/

	// Modified from the code removed from Tracekit in this commit
	// https://github.com/occ/TraceKit/commit/0d39401
	var _oldEventAdd = jQuery.event.add;
	jQuery.event.add = function(elem, types, handler, data, selector) {
		var _handler;
		var wrap = function(fn) {
			return function() {
				try {
					return fn.apply(this, arguments);
				} catch (e) {
					logException(e);
				}
			};
		};

		if (handler.handler) {
			_handler = handler.handler;
			handler.handler = wrap(handler.handler);
		} else {
			_handler = handler;
			handler = wrap(handler);
		}

		// If the handler we are attaching doesn’t have the same guid as
		// the original, it will never be removed when someone tries to
		// unbind the original function later. Technically as a result of
		// this our guids are no longer globally unique, but whatever, that
		// never hurt anybody RIGHT?!
		if (_handler.guid) {
			handler.guid = _handler.guid;
		} else {
			handler.guid = _handler.guid = jQuery.guid++;
		}
		return _oldEventAdd.call(this, elem, types, handler, data, selector);
	};

	//https://gist.github.com/ndbroadbent/5097601
	// Set up ajax prefilters once, using jQuery.Callbacks.
	// This lets us control a proxied callbacks list, so we can
	// clear the callback on tear down, and re-add it on setup.
	var wrapHandler = function (fnOriginHandler) {
		return function() {
			try {
				return fnOriginHandler.apply(this, arguments);
			} catch (e) {
				logException(e);
			}
		};
	};
	
	var jQuery_fn_on_original = jQuery.fn.on;
	jQuery.fn.on = function () {
		var args = Array.prototype.slice.call(arguments),
			fnArgIdx = 4;

		// Search index of function argument
		while((--fnArgIdx > -1) && (typeof args[fnArgIdx] !== 'function'));

		// If the function is not found, then subscribe original event handler function
		if (fnArgIdx === -1) {
			return jQuery_fn_on_original.apply(this, arguments);
		}

		// If the function is found, then subscribe wrapped event handler function
		args[fnArgIdx] = wrapHandler(args[fnArgIdx]);

		// Call original jQuery.fn.on, with the same list of arguments, but
		// a function replaced with a proxy.
		return jQuery_fn_on_original.apply(this, args);
	};

	var jQuery_fn_ready_original = jQuery.fn.ready;
	jQuery.fn.ready = function (handler) {
		// Call original jQuery.fn.ready, with the proxied handler.
		return jQuery_fn_ready_original.call(this, wrapHandler(handler));
	};

	var jQuery_fn_Callbacks_original = jQuery.Callbacks;
	jQuery.Callbacks = function( options ) {
		var result = jQuery_fn_Callbacks_original(options);
		
		var callbacks = ['add', 'fireWith'];
		for (var i=0; i<callbacks.length; i++) {
			if (result[callbacks[i]]) {
				result[callbacks[i]] = wrapHandler(result[callbacks[i]]);
			}
		}

		return result;
	};

	var jQuery_ajax_prefilters;
	if (!jQuery_ajax_prefilters) {
		jQuery_ajax_prefilters = jQuery.Callbacks();
		jQuery.ajaxPrefilter(jQuery_ajax_prefilters.fire);
	}

	// Set up prefilter that wraps ajax callbacks with try...catch blocks.
	jQuery_ajax_prefilters.add(function(options) {
		var callbacks = ['success', 'error', 'complete'];
		for (var i=0; i<callbacks.length; i++) {
			if (options[callbacks[i]]) {
				options[callbacks[i]] = wrapHandler(options[callbacks[i]]);
			}
		}
	});	
})(jQuery, window, document);
