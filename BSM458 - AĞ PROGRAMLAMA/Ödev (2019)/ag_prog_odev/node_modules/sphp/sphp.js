/*============================================================================*\
  Snappy PHP Script Launcher

  PHP script execution module for node
  Maintain a pool of ready workers for fast responcetime.

  Use as express middleware:
    app.use(sphp.express(<Document root>));

  or direct call
    sphp.exec

  To attach to websocket server:
    ws.on('connection',sphp.websocket(<options>));

  (c) Copyrights Paragi, Simon Riget 2013
  License MIT
\*============================================================================*/
var fs = require('fs');
var path = require('path');
var child_process = require('child_process');
var url = require('url');

var moduleVersion = 'Snappy PHP ' + require(__dirname + path.sep + 'package.json').version;

// Define module object
var sphp = {};
module.exports = exports = sphp;

// Initialize
sphp.worker=[];
sphp.increaseTime = false;

/*============================================================================*\
  Express Middleware to execute a PHP script.

  app.use(sphp.express(<array of options> | <PHP document root>));

  The script is expected to return a complete HTML response.
  The response will be partitioned into segments (using callback) of type:
    status
    header
    data (including stderr)
    end
    error

\*============================================================================*/
sphp.express = function (options) {
  // Maintain backwards compatibility
  if(typeof options !== 'undefined')
    if(typeof options === 'object')
      sphp.setOptions(options);
    else
      sphp.setOptions({'docRoot': options});

  // Return middleware function
  return function (request, response, next) {
    // Check file extension
    if (path.extname(request._parsedUrl.pathname).substring(1) !== 'php') {
      next();
      return 0;
    }

    // Launch script
    sphp.exec(request, function (event, data, param) {
      // console.log('----Receiving ',event,' With: ',data,':',param);
      if (!response.finished) {
        switch (event) {
          case 'status':
            response.status(data);
            break;

          case 'header':
            if (response.headersSent) break;
            response.setHeader(data, param);
            // Handle redirect header
            if (data.toLowerCase() === 'location') {
              response.writeHead(302, {'Content-Type': 'text/plain'});
              response.end('ok');
            }
            break;

          case 'data':
            response.write(data, 'utf-8');
            break;

          case 'end':
            response.end();
            break;

          case 'error':
            console.error(data);
            response.write(data, 'utf-8');
            break;

          default:
            console.error('PHP script unknown event: "%s"', event);
        }
      }
    });
  };
};

/*============================================================================*\
  Execute PHP script

  Start a PHP session, by deploying a prespawned worker.

  Using the script php_worker.php as a launcher script, to set predefined globals
\*============================================================================*/
sphp.exec=function(request,callback){
  var deployed=false;
  var freeWorker=false;

  // Initialize workers
  if(sphp.worker.length < 1)
    sphp.maintain();

// Check disabled for now. Is consistency really that important here? or  is it
// ok that PHP version is unknown to the first instanses of PHP scripts?
  if(false && typeof process.versions.php === 'undefined'){
    console.log('PHP engine is not initialized yet. The request was droped');
    return;
  }

  // Parse URL for websocket calls
  if(typeof request._parsedUrl === 'undefined')
    request._parsedUrl=url.parse(request.socket.upgradeReq.url);

  if(process.stdout.isTTY)
    console.log("Serving PHP page:", request._parsedUrl.pathname);

  // Check that script exists
  fs.exists(sphp.docRoot + request._parsedUrl.pathname, function(exists){
    // Deploy worker
    if(exists){
      // See if there is a free worker
      for(var i = sphp.worker.length-1; i >= 0 ; i--){
        // Deploy worker
        if(sphp.worker[i].proc.state=='ready') {
          // Set state
          sphp.worker[i].proc.state='running';
          sphp.worker[i].proc.time=Date.now();
          sphp.worker[i].proc.callback = callback;

          //Transfer conInfo request informastion to stdin
          sphp.worker[i].proc.conInfo = sphp._getConInfo(request);

          // Attach response handlers
          sphp._responseHandler(sphp.worker[i],callback)

          // Release input to worker (Let it run)
          sphp.worker[i].stdin.write(JSON.stringify(sphp.worker[i].proc.conInfo));
          sphp.worker[i].stdin.end();

          if(process.stdout.isTTY && false)
            console.info("Deploying worker PID: ",sphp.worker[i].pid);

          deployed=true;
          break;
        }
      }

      // Too busy
      if(!deployed){
        callback('status',503
          , "Sorry, too busy right now. Please try again later");
        callback('end');
      }

    // File not found
    }else{
      callback('status',404, "Sorry, unable to locate file: "
        +sphp.docRoot + request._parsedUrl.pathname);
      callback('end');
      console.info("File not found (404): "
        +sphp.docRoot + request._parsedUrl.pathname);
    }
  });
}

/*============================================================================*\
  Websocket: Attach on connection event

  Attach a "receive message" event handler
  If its a php file, execute it

  The options are the ones uset to setup express-session:

  var expressSession = require('express-session');
  var sessionStore = new expressSession.MemoryStore();
  var server = app.listen(8080,'0.0.0.0');
  var ws = new require('ws').Server({server: server});
  var sessionOptions={
     store: sessionStore
    ,secret:'yes :c)'
    ,resave:false
    ,saveUninitialized:false
    ,rolling: true
    ,name: 'SID'
  }

  app.use(expressSession(sessionOptions));
  ws.on('connection',sphp.websocket(sessionOptions));

  options: store and name must be set.

\*============================================================================*/
sphp.websocket = function (opt){
  var sessionCookieRegExp = new RegExp('(^|;)\\s*' + opt.name + '\\s*=\\s*([^;]+)');

  return function(socket,IncomingMessage) {
    //console.info("Client connected");

    if(typeof socket.upgradeReq == 'undefined') // WS 3.0 fix
      socket.upgradeReq = IncomingMessage;

    // Handler for incomming messages
    socket.on('message', function(msg){
      var sid;
      var parts;
      //console.info("Received ws message: ",request.body);

      // Create a pseudo request record
      var request={
         socket: socket
        ,body:   msg.toString()
      };

      // Parse POST body as JSON to PHP
      //socket.upgradeReq.headers['Content-Type']="application/json";

      //console.log("WS Headers: ",socket.upgradeReq.headers);

      // Find session cookie content, by name
      parts = decodeURI(socket.upgradeReq.headers.cookie).match(sessionCookieRegExp);
      //console.log("ws session parts: ",parts);
      if(parts){
        request.sessionID = parts[0].split(/[=.]/)[1];
        // SID is serialised. Use value between s: and . as index (SID)
        if(request.sessionID.substr(0,2) == 's:')
          request.sessionID=request.sessionID.substr(2);

        // Find session. Use value between s: and . as index (SID)
        opt.store.get(request.sessionID,function(error,data){
          if(data) request.session=data;
          // Execute php script

          sphp.exec(request,function(event,data){
            // Handle returned data
            if(event=='data' && request.socket.upgradeReq.socket.writable)
              request.socket.send(data);
              //console.log("Sending:",event,data);
          });
        },request);

      // Execute PHP without session
      }else sphp.exec(request,function(event,data){
        // Handle returned data
        if(event=='data' && request.socket.upgradeReq.socket.writable)
          request.socket.send(data);
          //console.log("Sending:",event,data);
      });
    });
  }
}

/*============================================================================*\
  Set options / configure sphp

  set one or more options.

  Options array of named key values pairs.

  sphp.setOptions(options);
  All options has been set to a defauls value
\*============================================================================*/
sphp.setOptions = function(option, callback){
  if(typeof option !== 'object') return;

  // Configure/overwrite option if any
  sphp.docRoot         = option.docRoot           || sphp.docRoot;
  sphp.minSpareWorkers = option.minSpareWorkers   || sphp.minSpareWorkers;
  sphp.maxWorkers      = option.maxWorkers        || sphp.maxWorkers;
  sphp.stepDowntime    = option.stepDowntime      || sphp.stepDowntime;
  sphp.overwriteWSPath = option.overwriteWSPaths  || sphp.overwriteWSPath;
  sphp.preLoadScript   = option.preLoadScript     || sphp.preLoadScript;
  sphp.superglobals    = option.superglobals      || sphp.superglobals;
  sphp.workerScript    = option.workerScript      || sphp.workerScript;
  sphp.cgiEngine       = option.cgiEngine         || sphp.cgiEngine;

  var list = [];
  for(var i in sphp)
    if(typeof sphp[i] !=='object' && typeof sphp[i] !=='function')
      list[i] = sphp[i];
  // console.log("Sphp options: ",list);
  // Get info on PHP engine. Throw fatal error if it fails.
  if(typeof option.cgiEngine === 'string'){
    var child = child_process.spawn(option.cgiEngine, ['-v']);
    child.resp = '';

    child.stdout.on('data', function (buffer) {
      child.resp += buffer.toString();
    });

    child.stderr.on('data', function (buffer) {
      child.resp += buffer.toString();
    });

    child.on('close', function () {
      process.versions.php = child.resp.split('\n')[0];
      if(process.versions.php.length <1)
        throw new Error("PHP engine '" +sphp.cgiEngine + "' failed to start.");
      console.log("PHP engine: " + process.versions.php);
      if( typeof callback === 'function')
        callback();
    });

    child.on('error', (error) => {
      throw new Error('PHP engine failed to start (' + sphp.cgiEngine +')');
    });
  }
}

/*============================================================================*\
Maintain PHP workers

PHP workers are preforked and kept ready, to improve response time.
The number of workers are determined by the demand. When minSpareWorkers are not
met do to demand, it is increased for a time. When it has not been needed for
stepDownTime, it is decreased again.

MinSpareWorkers: When a worker is spend (has run a script) it is terminated. If
the number of spare workers are below minSpareWorkers, new workers are forked.

Allocating more workers, will only improve response time up to a point. When the
resources becomes depleted, the only option is to prioritise and queue the
requests.

MaxWorkers: the number of workers that will never be exceed. Instead, the
request will be queued for maxWait time. If it expires the request are rejected.

Global variables are transfered via stdin, rather than enviroment variables, in
order to mimic the settings of Apache mod_php. That requires the pressens of a
php script that populates GLOBALS with data from stdin.

stdin is used to hold the process, until needed.

The list of workers are ordered with the oldest last, so that length reflects
the actual number of workers (Using add=>unshift delete=>splice)

Worker array objects layout:
   state: enum ready, running, spend
   time: of last state change
   proc: handle to spawned process
   cminSpareWorkers: current dynamic minimum of spare workers
   increaseTime: Time that i changed

\*============================================================================*/
sphp.maintain = function(){

  var spares = 0, workers = 0;

  if(typeof sphp.cminSpareWorkers === 'undefined')
    sphp.cminSpareWorkers = sphp.minSpareWorkers;

  // Count free workers
  for(var i in sphp.worker){
    if(sphp.worker[i].proc.state == 'ready') spares++
    if(sphp.worker[i].proc.state == 'dead')
      sphp.worker.splice(i,1);
    else
      workers++;
  }

  if(sphp.cminSpareWorkers < sphp.minSpareWorkers)
    sphp.cminSpareWorkers = sphp.minSpareWorkers;

  // increase number of workers
  if(spares<1 && workers < sphp.maxWorkers){
    if(sphp.increaseTime) sphp.cminSpareWorkers++;
    sphp.increaseTime = Date.now();

  // Decrease number of workers
  }else if(Date.now() - sphp.increaseTime>sphp.stepDowntime * 1000) {
    if(sphp.cminSpareWorkers > sphp.minSpareWorkers) sphp.cminSpareWorkers--;
    sphp.increaseTime = Date.now();
  }

  // Start spare workers
  var option = {cwd: sphp.docRoot, env: process.env};

  if(sphp.preLoadScript)
    option.env.preload =  sphp.docRoot + path.sep + sphp.preLoadScript;

  for(; spares < sphp.cminSpareWorkers && workers < sphp.maxWorkers; spares++){
    // Start child process and Append worker to array
    sphp.worker.unshift(
      child_process.spawn(
         sphp.cgiEngine
        ,[sphp.workerScript]
        ,option
      )
    );

    // Attach end of process event
    sphp.worker[0].on('exit' , handleExit );
    sphp.worker[0].on('close', handleExit );
    sphp.worker[0].on('error', handleExit );

    // Some process settings
    sphp.worker[0].stderr.setEncoding('utf-8');
    sphp.worker[0].stdout.setEncoding('utf-8');
    sphp.worker[0].stdout.parent = sphp.worker[0];
    sphp.worker[0].stderr.parent = sphp.worker[0];
    sphp.worker[0].proc = {
       state: 'ready'
      ,time: Date.now()
      ,outBuffer: ''
      ,errorBuffer: ''
    }

    if(!sphp.worker[0].pid) return;

    // Make temporary listners for output (Errors)
    sphp.worker[0].stdout.on('data', function(data) {
      if(sphp.worker[0].proc.outBuffer.length < 4096)
        sphp.worker[0].proc.outBuffer += data.toString();
    });

    sphp.worker[0].stderr.on('data', function(data) {
      if(this.parent.proc.errorBuffer.length < 4096)
        this.parent.proc.errorBuffer += data.toString();
    });

    workers++;
  }

  function handleExit(report) {
    if(report && (typeof this.proc === 'undefined' || this.proc.state=='ready')){
      //console.log("Exit handler:", report);
      var str = "Failed to start PHP worker."
      str += "\n  PHP engine: " + sphp.cgiEngine;
      str += "\n  PHP engine version: " + process.versions.php;
      str += "\n  Worker script: " + sphp.workerScript;
      //str += "\n  Worker PID: "+worker.pid;
      str+="\n  Error: " + report;
      if(this.proc.errorBuffer.length || this.proc.outBuffer.length){
        str += "\n  Script error message: "
        str += "\n" + this.proc.outBuffer
        str += "\n" + this.proc.errorBuffer;
      }
      this.proc.state="dead";
      throw new Error(str);
    }
    if(this.proc.state!='dead')
      process.nextTick(sphp.maintain);
  }

  // report on workers
  if(process.stdout.isTTY && false){
    console.info(("=").repeat(80));
    console.info(
      "PHP Workers spares:"
      ,spares
      ," min:"
      ,sphp.cminSpareWorkers
      ," Max:"
      ,sphp.maxWorkers
    );

    workers=0; spares=0;
    for(var i in sphp.worker){
      workers++;
      console.info(i,"PID:",sphp.worker[i].pid," State:",sphp.worker[i].proc.state
        ," age:",+(Date.now()-sphp.worker[i].proc.time)/1000+" Seconds");
      // Find free workers
      if(sphp.worker[i].state=='ready') spares++
    }
    console.info(("=").repeat(80));
  }
}

/*============================================================================*\
  Handle output from the spawned process

  request body part and other information are parsed through stdin, to the php
  process. body including multipart are interpreted by the server, before parsing
  it to the cgi.
  Node provides for the uploaded files to be stored. they only need to be renamed
  and information passed.

  on reveiving data on stdid, all input is treated as headers, until end of
  header section is send (double windows end of line: \n\r\n\r)

  Data are received in multi part blocks, with no regard to the content.
  eg. a data block might contain both headers, [end of header] and body

  The receiving callback function must have data separated in:
    status, header, data, error and end request.

  Status 200 OK is assumed, if not set.

  Note: if header contains a redirect (Location) the status must be set accordingly

  Quirks:
    1. php-cgi might send error text formatted in HTML before the headers
      Fix: 1. error messages are stores until headers are send.
           2. a default header of Content-type: text/html (overwritten if other))
    2. php-cgi might send a header in one block and the line ending in another
      Fix: buffer all headers until end of header section are received
    3. the phpinfo() function requests pseudo pages for logo images.

    for strange 404 see http://woozle.org/~neale/papers/php-cgi.html

\*============================================================================*/
sphp._responseHandler= function (worker,callback){
  worker.proc.outBuffer='';
  worker.proc.errorBuffer='';
  worker.proc.headersSent = false;
  worker.proc.headers='';

  // Remove listners for workers in idle state
  worker.stdout.removeAllListeners('data');
  worker.stderr.removeAllListeners('data');
  worker.removeAllListeners('error');
  worker.removeAllListeners('exit');
  worker.removeAllListeners('close');

  // Catch output from script and send it to client
  worker.stdout.on('data', function(data){
    var worker = this.parent;
    var redirect = false;
    if(worker.proc.state != 'running') return;
    if(!worker.proc.headersSent){
      // Store headers until a end of header is received (\r\n\r\n)
      worker.proc.headers += data.toString();

      // Pre-process headers: divide headers into lines and separate body data
      var eoh = worker.proc.headers.indexOf('\r\n\r\n');
      var eohLen = 4;
      if(eoh <= 0){
        eoh = worker.proc.headers.indexOf('\n\n');
        eohLen = 2;
      }

      if(eoh >= 0){
        var line = worker.proc.headers.substr(0,eoh).split('\n');
        var div;
        for(var i in line){
          // Split header line into key, value pair
          div = line[i].indexOf(":");
          if(div>0){
            var key = line[i].substr(0,div);
            var value = line[i].substr(div+2).replace("\r","");
// console.log("Sending header 1:",key,":",value);
            callback('header',key,value);
          }
        }
        worker.proc.headersSent = true;

        // Handle redirect location header
        // Send body part if any
        if(worker.proc.headers.length>eoh+eohLen){
          callback('data',worker.proc.headers.substr(eoh+eohLen));
        }
      }

    // Body
    }else{;
      callback('data',data.toString());
    }
  });

  // Error. Catch standard error output from script (but don't send it until the end)
  worker.stderr.on('data', (function(worker,callback){
    return function (data) {
      if(worker.proc.errorBuffer.length < 4096)
        worker.proc.errorBuffer += data.toString();
    };
  })(worker,callback));

  worker.stdout.on('close', (function(worker,callback){
    return function () { endWithGrace(worker,callback); };
  })(worker,callback));

  worker.stderr.on('close', (function(worker,callback){
    return function () { endWithGrace(worker,callback); };
  })(worker,callback));

  worker.on('exit', (function(worker,callback){
    return function () { endWithGrace(worker,callback); };
  })(worker,callback));

  worker.on('error', (function(worker,callback){
    return function () { endWithGrace(worker,callback); };
  })(worker,callback));

  function endWithGrace(worker,callback){
    if(worker.proc.state == 'running'){
      worker.proc.state = 'dead';
      if(!worker.proc.headersSent){
        callback('header','Content-type','text/html'); // Fix 1
        var eoh = worker.proc.headers.indexOf('\r\n\r\n');
        if(eoh >= 0 && worker.proc.headers.length > eoh+4)
          callback('data',worker.proc.headers.substr(eoh+4));
      }
      if(worker.proc.outBuffer.length) callback('data',worker.proc.outBuffer);
      if(worker.proc.errorBuffer.length) callback('error',worker.proc.errorBuffer);
      callback('end');
      process.nextTick(sphp.maintain);
    }
  }
}

/*============================================================================*\
  Compose a connection information record on client request

┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│                                            href                                             │
├──────────┬──┬─────────────────────┬─────────────────────┬───────────────────────────┬───────┤
│ protocol │  │        auth         │        host         │           path            │ hash  │
│          │  │                     ├──────────────┬──────┼──────────┬────────────────┤       │
│          │  │                     │   hostname   │ port │ pathname │     search     │       │
│          │  │                     │              │      │          ├─┬──────────────┤       │
│          │  │                     │              │      │          │ │    query     │       │
"  https:   //    user   :   pass   @ sub.host.com : 8080   /p/a/t/h  ?  query=string   #hash "
│          │  │          │          │   hostname   │ port │          │                │       │
│          │  │          │          ├──────────────┴──────┤          │                │       │
│ protocol │  │ username │ password │        host         │          │                │       │
├──────────┴──┼──────────┴──────────┼─────────────────────┤          │                │       │
│   origin    │                     │       origin        │ pathname │     search     │ hash  │
├─────────────┴─────────────────────┴─────────────────────┴──────────┴────────────────┴───────┤
│                                             URI                                             │
├─────────────────────────────────────────────────────────┬───────────────────────────┬───────┤
│                                                         │          URL              │       │
└─────────────────────────────────────────────────────────┴───────────────────────────┴───────┘

REMOTE_PORT = socket.remotePort
REMOTE_ADDR = socket.remoteAddress
DOCUMENT_ROOT = File system full path to root of hosted files.
SCRIPT_NAME = pathname: path relative to document root, with filename and extention
PHP_SELF = SCRIPT_NAME;
SCRIPT_FILENAME = DOCUMENT_ROOT + SCRIPT_NAME
SERVER_HOST = host (with port)
SERVER_NAME = hostname (SERVER_HOST without port)
\*============================================================================*/
sphp._getConInfo=function(request){
  // Copy predefined super globals
  var conInfo = JSON.parse(JSON.stringify(sphp.superglobals));
  var extReq;

  /*==========================================================================*\
    Websocket request
  \*==========================================================================*/
  if(typeof request.socket  == 'object'
      && typeof request.socket.upgradeReq != 'undefined'
      && typeof request.socket.upgradeReq.headers != 'undefined'){

    extReq = request.socket.upgradeReq;
    conInfo._SERVER.REMOTE_PORT = request.socket._socket.remotePort || '';
    conInfo._SERVER.REMOTE_ADDR = request.socket._socket.remoteAddress || '';
    conInfo._SERVER.REQUEST_METHOD = 'websocket';
    conInfo._GET = url.parse(request.socket.upgradeReq.url, true).query;

   /*==========================================================================*\
    basic HTTP request
  \*==========================================================================*/
  }else{
    extReq = request;
    if(typeof request.client  == 'object'){
      conInfo._SERVER.REMOTE_ADDR = request.client.remoteAddress || '';
      conInfo._SERVER.REMOTE_PORT = request.client.remotePort || '';
    }
    conInfo._SERVER.REQUEST_METHOD = request.method || '';
    conInfo._GET = request.query || {};
    conInfo._FILES = {};
    for(var f in request.files){
      conInfo._FILES[f]={};
      conInfo._FILES[f].name=request.files[f].name;
      conInfo._FILES[f].size=request.files[f].size;
      conInfo._FILES[f].tmp_name=request.files[f].path;
      conInfo._FILES[f].type=request.files[f].type;
    }
  }

  /*==========================================================================*\
  // Non method specifics
  \*==========================================================================*/
  conInfo._SERVER.SERVER_PROTOCOL =
    extReq.httpVersion ? "HTTP/" + extReq.httpVersion : '';

  conInfo._SERVER.DOCUMENT_ROOT = path.resolve(sphp.docRoot);

  if(request._parsedUrl){
    conInfo._SERVER.REQUEST_URI = request._parsedUrl.href;
    conInfo._SERVER.QUERY_STRING = request._parsedUrl.query;

// Does this work in windows !?
    conInfo._SERVER.SCRIPT_NAME = request._parsedUrl.pathname || '/';
    if(conInfo._SERVER.SCRIPT_NAME.charAt(0) != '/')
      conInfo._SERVER.SCRIPT_NAME = '/' + conInfo._SERVER.SCRIPT_NAME;
    conInfo._SERVER.PHP_SELF = conInfo._SERVER.SCRIPT_NAME;
    conInfo._SERVER.SCRIPT_FILENAME = conInfo._SERVER.DOCUMENT_ROOT
    + conInfo._SERVER.SCRIPT_NAME;

    if(request._parsedUrl.host)
      conInfo._SERVER.SERVER_HOST = request._parsedUrl.host;
  }

  if(typeof extReq.headers === 'object')
      for(var key in extReq.headers)
        conInfo._SERVER['HTTP_' + key.toUpperCase().replace('-','_')]
          = extReq.headers[key];

  if(typeof conInfo._SERVER.HTTP_REFERER !== 'undefined'){
    var refererUrl = url.parse(conInfo._SERVER.HTTP_REFERER);
    conInfo._SERVER.SERVER_PORT = refererUrl.port;
    conInfo._SERVER.SERVER_ADDR = refererUrl.hostname;
    if(typeof conInfo._SERVER.SERVER_NAME === 'undefined'
      || conInfo._SERVER.SERVER_NAME.length == 0)
      conInfo._SERVER.SERVER_NAME = refererUrl.hostname;
  }

  if(typeof conInfo._SERVER.HTTP_COOKIE !== 'undefined'){
    conInfo._SERVER.HTTP_COOKIE_PARSE_RAW = conInfo._SERVER.HTTP_COOKIE;
    var line = conInfo._SERVER.HTTP_COOKIE_PARSE_RAW.split(';');
    for(var i in line){
      var cookie = line[i].split('=');
      if(cookie.length >0)
        conInfo._COOKIE[cookie[0].trim()] = cookie[1].trim();
    }
  }

  if(typeof request.body !== 'object' && request.body)
    try{
      conInfo._POST = JSON.parse(request.body);
    }catch(e){}
  else
    conInfo._POST = request.body || {};

  conInfo._REQUEST = Object.assign({}, conInfo._GET, conInfo._POST, conInfo._COOKIE);

  if(request.session)
    conInfo._SERVER.SESSION = request.session;

  return conInfo;
}

// Set defaults
sphp.setOptions({
   docRoot:         path.resolve("." + path.sep + 'public')
  ,minSpareWorkers: 10
  ,maxWorkers:      20
  ,stepDowntime:    360
  ,overwriteWSPath: null
  ,cgiEngine:       'php-cgi' + (/^win/.test(process.platform) ? '.exe'  : '')
  ,workerScript:    __dirname + path.sep + 'php_worker.php'
  ,superglobals: {
    _POST: {},
    _GET: {},
    _FILES: {},
    _SERVER: {
      GATEWAY_INTERFACE: moduleVersion,
      SERVER_SOFTWARE: 'PHP Appilation Server using Node.js and WS Websockets',
      SERVER_NAME: 'localhost'
    },
    _COOKIE: {}
  }
});
