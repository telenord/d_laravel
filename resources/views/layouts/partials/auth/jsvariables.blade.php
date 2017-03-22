{{--
This file is part of laravel-bootstrap-adminlte-starter-kit.

Copyright (c) 2016 Oleksii Prudkyi
--}}

{{-- this is js stuff loaded a top --}}
<script>
@if(env('APP_ENV', false) == 'testing')
{{-- translate errors to codeception friendly data --}}
var JSEH_showUncaughtException = function(message) {
    "use strict";

    if(typeof message === "undefined") {
        return false;
    }
	document.head.setAttribute( 'data-jserror', message );
    alert(message);
};
var JSEH_enabled = true;  

{{-- catch errors even before js-error-alert is initialized --}}
window.onerror = function (errorMsg, url, lineNumber, column, errorObj) {
	"use strict";

	if(typeof errorMsg == "undefined") {
		return false;
	}

	JSEH_showUncaughtException("JS Error : " + errorMsg + "\n" +
		"line number : " + lineNumber + "\n" +
		"column : " + column + "\n" +
		"object : " + errorObj
		);
		
	return false;
};

{{-- catch image not found errors  --}}
document.addEventListener( 'DOMContentLoaded', function() {
	var img = document.getElementsByTagName( 'img' );
	for ( var i = 0; i < img.length; i++ ) {
		img[i].addEventListener( 'error', function( e ) {
			var msg = this.src + ' not found.';
			document.head.setAttribute( 'data-imgerror', msg );
		} );
	}
});
@else
{{-- enable js-error-alert --}}
var JSEH_enabled = @if(env('JS_ERROR_ALERTER_ENABLED', false)) true @else false @endif ;
@endif

</script>

