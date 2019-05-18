/**
 * ESAPI (The OWASP Enterprise Security API) is a free, open source, web application security control library that makes it easier for programmers to
 * write lower-risk applications. The ESAPI libraries are designed to make it easier for programmers to retrofit security into existing applications.
 * The ESAPI libraries also serve as a solid foundation for new development. (https://www.owasp.org/index.php/Category:OWASP_Enterprise_Security_API)
 *
 * For more information:
 * https://static.javadoc.io/org.owasp.esapi/esapi/2.1.0/org/owasp/esapi/Encoder.html#encodeForSQL(org.owasp.esapi.codecs.Codec,%20java.lang.String)
 *
 */

var ESAPI = require('node-esapi');
// - Step 2: Encode the user input that will be logged in the correct context
// following are a few examples:

&lt;script&gt;alert&#x28;&#x27;xy&#x27;&#x29;&#x3b;&lt;&#x2f;script&gt;
console.log('Error: attempt to login with invalid user: %s', ESAPI.encoder().encodeForHTML('<script>alert(\'xy\');</script>'));
console.log('Error: attempt to login with invalid user: %s', ESAPI.encoder().encodeForJavaScript('<script>'));
console.log('Error: attempt to login with invalid user: %s', ESAPI.encoder().encodeForURL('<script>'));

console.log('Error: attempt to login with invalid user: %s', ESAPI.encoder().encodeForHTML("u<ntrus>te'd'"));
console.log('Error: attempt to login with invalid user: %s', ESAPI.encoder().encodeForJavaScript("u<ntrus>te'd'"));
console.log('Error: attempt to login with invalid user: %s', ESAPI.encoder().encodeForURL("u<ntrus>te'd'"));

/*

// HTML Context
String html = Encoder.forHtml("u<ntrus>te'd'");

// HTML Attribute Context
String htmlAttr = Encoder.forHtmlAttribute("u<ntrus>te'd'");

// Javascript Attribute Context
String jsAttr = Encoder.forJavaScriptAttribute("u<ntrus>te'd'");*/
