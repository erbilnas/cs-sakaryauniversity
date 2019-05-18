<!DOCTYPE HTML>
<html>
<head>
<title>Snappy PHP</title>
<link href="base.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
function request(msg){
  document.forms['sphp'].func.value=msg;
  document.forms['sphp'].submit();
}
</script>
</head>

<body>
<form method="POST" name="sphp">
<input type="hidden" name="func">
</form>
<h1>Snappy PHP</h1>
This is a PHP page<br>
<div class="tile" onclick="window.location.href='example.html';">
Go to HTML page</div>
<div class="tile" onclick="request('PHP');">
PHP GLOBALS from script</div>
<div class="tile" onclick="request('WS');">
Show PHP GLOBALS through PHP websocket</div>
<br>
<div class="container">

<?php
require('websocket_client.php');

// Handle request
if(isset($_POST['func'])) switch($_POST['func']){
  case 'PHP': // Show Globals
    echo "<pre>Output from ".__FILE__.":</br>";
    echo print_r($GLOBALS,true)."</pre>";
    echo "__FILE__: ",__FILE__;
    break;
  case 'WS': // Aks the websocket server to show its globals
    $sp=websocket_open('127.0.0.1:8080/ws_request.php?param=php_test',$errstr);
    if(!$sp) trigger_error($errstr);
    // Send command and wait for an answer synchronously
    websocket_write($sp,json_encode(["php"=>"websocket"]));
    echo "<Output via PHP websocket:</br>\n";
    echo websocket_read($sp,true);
    break;
}
echo "</div>";
?>
</div>
</body>
</html>
