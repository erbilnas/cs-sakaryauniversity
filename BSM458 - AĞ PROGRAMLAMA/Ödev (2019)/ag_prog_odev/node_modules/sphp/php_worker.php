<?php
/* ======================================================================== *\
  Snappy PHP Script Launcher
 
  Pre burner for PHP script execution with note.js

  This script initialise various predefined globals in PHP
  The STDIN stream/socket contains a JSON encoded array, containing all relevant
  data.

  This is a close aproximation to the population of globals done by mod_php in Apache

todo:
  fake header()
  set ini open_basedir
  file upload

 (c) Copyrights Paragi, Simon Riget 2013
 Licence MIT
\* ======================================================================== */
// Prevent that the input socket times out, before it is used
ini_set ("default_socket_timeout","-1" );

// include pre load script
$pre_load_script = getenv('preload');
if(!empty($pre_load_script))
  include($pre_load_script);

//   Get client request and server information passed throug stdin.
$request=json_decode(file_get_contents("php://stdin"),true);

// Populate predefined global variables, including all http headers
unset($_SERVER,$_REQUEST);
foreach($request as $key => $value)
  $$key = $value;

// Clean up
unset($request, $key, $value);

// Set server signature
$_SERVER['SERVER_SIGNATURE'] =
   "<address>"
   . $_SERVER['SERVER_SOFTWARE']
  . ". With " . $_SERVER['GATEWAY_INTERFACE']
  . (empty($_SERVER['SERVER_HOST']) ? '' : " at " . $_SERVER['SERVER_HOST'])
  . "</address>";
;

// Run script
if(realpath($_SERVER['SCRIPT_FILENAME'])){
  chdir(dirname($_SERVER['SCRIPT_FILENAME']));
  require $_SERVER['SCRIPT_FILENAME'];
}else{
  trigger_error("File $_SERVER[SCRIPT_FILENAME] Missing", E_USER_ERROR);
}

?>
