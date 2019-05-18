## Snappy PHP for node js
A snappy PHP module / middleware.

Fast response time is favored over use of resources and performance under load. This package is best suited embedded system and small application with few user, where you just need a fastest response time without much load.

Features:
* Use PHP in node with express, sessions and websockets. 
* Transfer node express session to php and reuse session ID and cookie from express
* No dependencies (except for example)
* Mimic Apache mod_php population of the PHP super globals
* Highly configurable.
* Comes with an example of a server using PHP websocket client

**Note:** php-cgi must be installed. If its not in the PATH, the variable cgiEngine must be set to point to the executable binary.

File upload is disabled at present.

#### Install

    npm install sphp
    
#### Run example server

Make sure php-cgi is installed and in the path. (not just php)

    npm install express express-session ws body-parser

Change directory to to where sphp reside (node_module/...):

    cd sphp

Run the example server

  node example.js

Connect to the exampleserver in a browser:

    http://localhost:8080  or  http://<address of server>:8080       

You should now se the example pages.
    

### Set up with an express server

    var express = require('express');
    var sphp = require('sphp');
    
    var app = express();
    var server = app.listen(8080);
    
    app.use(sphp.express('public/'));
    app.use(express.static('public/'));


### Set up with an express server and websockets

    var express = require('express');
    var sphp = require('sphp');
    
    var app = express();
    var server = app.listen(8080);
    var ws = new require('ws').Server({server: server});
    
    app.use(sphp.express('public/'));
    ws.on('connection',sphp.websocket());
    app.use(express.static('public/'));

    
#### Set up with an express server and express-session

    var express = require('express');
    var expressSession = require('express-session');
    var bodyParser = require('body-parser');
    var sessionStore = new expressSession.MemoryStore();
    var sphp = require('sphp');
    
    var app = express();
    var server = app.listen(8080);
    var sessionOptions={
         store: sessionStore
        ,secret:'yes :c)'
        ,resave:false
        ,saveUninitialized:false
        ,rolling: true
        ,name: 'SID'
    }

    app.use(expressSession(sessionOptions));
    app.use(function(request, response, next){ 
      // Save session data
      request.session.ip=request.client.remoteAddress;
      next();
    });
    app.use(bodyParser.json());      
    app.use(bodyParser.urlencoded({extended: true}));

    app.use(sphp.express('example/'));
    ws.on('connection',sphp.websocket(sessionOptions));
    app.use(express.static('example/'));


### Configuration
SPHP settings can be changed by parsing an array of options to change to the setOptions or express methods. 

Set all options:

	var sphpOptions = {
 	     cgiEngine: “/usr/bin/php-cgi'
	    ,docRoot: “/home/of/my/pubnlic/files”
	    ,minSpareWorkers: 4
	    ,maxWorkers: 20
	    ,stepDowntime: 1800
	    ,overwriteWSPath: “/ws_serveice.php”
	    , preLoadScript: “pre_load.php”
	    ,superglobals: {_SERVER.SERVER_NAME: “MyServer.com”}
	};
    
	sphp.setOptions(sphpOptions);

or alternatively parsed with the express middleware setup:

	app.use(sphp.express(sphpOptions));

To set the server name:

	sphp.setOptions({
	  superglobals: {
	    _SERVER: {
	      SERVER_NAME: "MyServer.com"
	    }
	  }
	});
	
To load the enviroment variables:

    sphp.setOptions({
      superglobals: {
        _ENV: JSON.parse(JSON.stringify(process.env)
      }
    });

|variable name |  |
|---|---|
|cgiEngine |Default: "php-cgi" Specify which binary file to use to execute PHP script. The executable must be in the environment PATH or use a full path to the executable file.|
|docRoot |(default: "./public" Where to serve script files from. Might be relative or an absolute path. This is the variable set, when sphp.express is called with a parameter.|
|minSpareWorkers |Default: 2. Define the minimum number of workers kept ready. <br>Note that when calling PHP scripts through websockets, an additional concurrent worker is used. |
|maxWorkers |Default: 10. The maximum number of workers allowed to start. This number will never be exceeded. Requests will instead be rejected. Set this to limit the amount of RAM the server can use, when load is high. The footprint is about 20MB / worker as of php-cgi 5.4 php-gci. 
|stepDowntime |Default: 360 seconds. The number of worker are increased dynamically, When the need arises. This is the time it takes before, the number of workers, are reduced by one.|
|overwriteWSPath |Default null. Used to specify which script should serve a websocket request.<br>If null, the URL of the connection GET request is used. The path is relative to docRoot.|
|preLoadScript |Default null. This can be used to preload libraries, before a page is requested, thus improving reaponcetime. The preLoadScript variable contains a path to a php script, relative to docRoot. Be aware that the script pointet to will be executed when the php engine is loaded eg. before a client has made a page request. non of the super globals are set to usefull values at this point. The script sould contain generic library function that are use system wide, as it will be loaded with all page.|
|superglobals | This can be used to preset PHP superglobals like $_SERVER['SERVER_NAME'] Any variable can be set, but will be overwriten, if the name is one of thouse that is set during request time, except SERVER_NAME.<br>The following variables are predefined and will be futher populated at request time:<br>    _POST<br>    _GET<br>    _FILES<br>    _SERVER: SERVER_SOFTWARE,    SERVER_NAME<br>    _COOKIE|

### Notes
The aim of this project is to serve PHP scripts with the best response time possible. Another important functionality is integration with websocket and access to the express servers session data.

The responsetime is achieved by sacrificing considerations of resources and performance under load. This is implemented  by pre-emptively loading of the PHP-CGI engine and a user PHP script, typically including generic PHP library. The process is then put on hold until needed.

### Changes
* 0.6.2 Super global SERVER_NAME respects option setting over value generated at request time
	      Minor consistance corrections in the code
      	Documentation update 
* 0.6.1 Fixed direct call to sphp.exec to function, before express is started.
* 0.6.0 Adapted to windows and OSX platforms
        Option settings changed to match recognised usual praxis for express middleware
        Improved tests structure
        Check validity of PHP engine and respond with clearer error messages if missing
        Check and report PHP version in process.versions
        Report SPHP version correct in all instances
* 0.5.2 Fixed Websocket parse url bug
* 0.5.1 Documentation update
* 0.5.0 Added superglobals preset options
        Fixed Cr/Nl in headers (compattible to express 4)
        fixed too few spare workers started, when minSpareWorkers > default value
session.sid is no longer set
* 0.4.3 Updated denendencies
* 0.4.0 Updated to run with express v4
* 0.4.0 Updated to run with express v4 
        PHP output on standart-error are now send when closing.
        stderr now gets loged to console.error. 
        Changed 'binary' transfer mode to 'UTF-8' to acommodate browser changes
        Fixed race condition when termination with error.
        Fixed websocket error, when not having a session id.
        Fixed PHP_worker.php warning.
* 0.3.15 Output to stderr is now returned last, and loged to server erro output.
* 0.3.14 Added server session ID to session
         conInfo.session.sid = request.sessionID;
         php_worker uses session.sid from server session rather than cookie  
         node version 7 compatible
         Try harder to make sense og request record
* 0.3.13 Websocket body can now be either a string or an object
* 0.3.12 Documentation update
* 0.3.11 Documentation update
* 0.3.10 Preloading php library scripts, to improve responsetime
* 0.3.9  Documentation update
* 0.3.8  php_worker.php Typo
* 0.3.7  PHP session cookie disabled.
* 0.3.6  Websocket Error 'not opened' when script don't exists
* 0.3.5  open_basedir restriction, without specifying doc roor in php.ini

### Help
I appreciate contributions. Code should look good and compact, and be covered by a test case or example.
Please don't change the formatting style laid out, without a good reason. I know its not the most common standard, but its a rather efficient one with node.

Don't hesitate to submit an issue on github. But please provide a reproducible example.

