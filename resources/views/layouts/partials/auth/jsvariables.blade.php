{{-- this is js stuff loaded a top --}}
<script>
/*
 * Main error handler, helps to popup errors earlier
 */

var showUncaughtException = function(message) {
	"use strict";

	if(typeof message == "undefined") {
		return false;
	}
	alert(message);
}

window.onerror = function (errorMsg, url, lineNumber, column, errorObj) {
	"use strict";

	if(typeof errorMsg == "undefined") {
		return false;
	}

	showUncaughtException("JS Error : " + errorMsg + "\n" +
		"line number : " + lineNumber + "\n" +
		"column : " + column + "\n" +
		"object : " + errorObj
		);
        
    // Tell browser to run its own error handler as well   
    return false;
}
</script>

