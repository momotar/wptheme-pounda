var elements = document.getElementsByTagName("pre");
(function(d){
	if (elements.length > 0) {
		var s = d.getElementsByTagName('script')[0];
		var c1 = d.createElement('link');
		c1.rel = 'stylesheet';
		c1.href = '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/styles/monokai-sublime.min.css';
		s.parentNode.insertBefore(c1, s);
	}
})(document);
function loadScript(src, callback) {
	if (elements.length > 0) {
	    var done = false;
	    var head = document.getElementsByTagName('head')[0];
	    var script = document.createElement('script');
	    script.src = '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/highlight.min.js';
	    head.appendChild(script);
	    // Attach handlers for all browsers
	    script.onload = script.onreadystatechange = function() {
	        if ( !done && (!this.readyState ||
	                this.readyState === "loaded" || this.readyState === "complete") ) {
	            done = true;
	            callback();
	            // Handle memory leak in IE
	            script.onload = script.onreadystatechange = null;
	            if ( head && script.parentNode ) {
	                head.removeChild( script );
	            }
	        }
	    }
	}
}
loadScript("highlight.min.js", function() {
    hljs.initHighlightingOnLoad();
});