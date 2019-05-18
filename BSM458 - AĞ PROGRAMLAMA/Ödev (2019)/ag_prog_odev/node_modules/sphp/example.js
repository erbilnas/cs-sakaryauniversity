/*============================================================================*\
  Example of webserver using PHP and websockets served on the same port (80)

  (c) Paragi Aps, Simon Riget 2015.
  Free to use, provided copyright note is preserved

  This example is showing how to make a:
  * Snappy PHP serverside scripting
  * Websocket support, utilising PHP script to serve requests
  * Transferring node sessions to PHP

  Sessions are created on a regular HTTP page request. The generated session are
  then used with the websocket request, identified by the same session ID cookie

  Note: This example depends on the modules: express, ws express-session and
        body-parser:

        npm install express ws express-session body-parser


  The script php_worker.php is always called, to set globals correctly etc.
  The requested script are included by this script.
\*============================================================================*/
// Catch missing modules
process.on('uncaughtException', function(err) {
  console.error("example.js requires modules installed. Use:"
    + "\n\n  npm install express express-session ws body-parser"
    + "\n\nError: ",err.message);
});

// Load modules
var express = require('express');
var expressSession = require('express-session');
var bodyParser = require('body-parser');
var _ws = require('ws');
var path = require('path');

process.removeAllListeners('uncaughtException');

// Initialize server
var sessionStore = new expressSession.MemoryStore();
var sphp = require('./sphp.js');
var app = express();
var server = app.listen(8080,'0.0.0.0','',function () {
  console.log('Server listening at://%s:%s'
    ,server.address().address
    ,server.address().port);
});
var ws = new _ws.Server({server: server});

// Set up session. store and name must be set, for sphp to catch it

var docRoot = module.filename.substring(0,module.filename.lastIndexOf(path.sep)) + '/example/';

var sessionOptions={
   store: sessionStore
  ,secret:'yes :c)'
  ,resave:false
  ,saveUninitialized:false
  ,rolling: true
  ,name: 'SID'
}

var sphpOptions = {
   overwriteWSPath: "/ws_request.php"
  ,docRoot: docRoot
}
/*============================================================================*\
  Middleware
\*============================================================================*/
// Attach session control
app.use(expressSession(sessionOptions));

// Save some session specific data
app.use(function(request, response, next){
  request.session.ip=request.client.remoteAddress;
  next();
});

// Parsing POST requests (Not for websockets)
app.use(bodyParser.json());       // to support JSON-encoded bodies
app.use(bodyParser.urlencoded({extended: true})); // to support URL-encoded bodies

// Attach sPHP
app.use(sphp.express(sphpOptions));

// Attach sPHP execution to the websocket connect event
ws.on('connection',sphp.websocket(sessionOptions));

// Setup html file server
app.use(function(request, response, next){
  if(request._parsedUrl.pathname == '/')
    request._parsedUrl.pathname='/example.html';
  next();
});
app.use(express.static(docRoot));
