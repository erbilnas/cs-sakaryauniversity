<?php
  // This script is called through websockets
  
  // Send a list of global variable and values to the client
  echo "<pre>Output from ".__FILE__."\n".print_r($GLOBALS,true)."</pre>";
?>
