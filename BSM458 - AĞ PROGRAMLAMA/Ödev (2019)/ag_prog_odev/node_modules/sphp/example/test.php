<?php
//setcookie("AAA", "value", -1, '/', ".domain.com")
setcookie("AAA", "value", -1, '/', ".localhost");
//setcookie("BAA", "other value", -1, '/', ".localhost");
//  header('Location: http://localhost:8080/test.html');
?><!DOCTYPE HTML>
<html>
<head>
<title>Test page</title>
<link href="base.css" type="text/css" rel="stylesheet">

<style>
</style>

</head>
<body>
<h1>Test af websocket klient</h1>

<?php
//echo "<pre>".print_r($_SERVER,true)."</pre>";      

function hex_dump($data, $newline="\n")
{
  static $from = '';
  static $to = '';

  static $width = 16; # number of bytes per line

  static $pad = '.'; # padding for non-visible characters

  if ($from==='')
  {
    for ($i=0; $i<=0xFF; $i++)
    {
      $from .= chr($i);
      $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
    }
  }

  $hex = str_split(bin2hex($data), $width*2);
  $chars = str_split(strtr($data, $from, $to), $width);

  $offset = 0;
  foreach ($hex as $i => $line)
  {
    echo sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2)) . ' [' . $chars[$i] . ']' . $newline;
    $offset += $width;
  }
}
/*----------------------------------------------------------------------------*\
Set timeouts to very small values.

This code is very simple and dose not handle different versions or negotiations 
of any kind. It only has to work with this particular server.

Send a command or a list of commands to the eventhandler handler

send_event_signal

Event names for interactions are a full path context + interaction name

  Commands (and events) coded into a page, must have an underscore or slash to 
  avoid confusing them with spoken user commands.

  message format
  command: 
    cmd:    <command>
    cmd_id: a scalar value will bereturned with the reply, to identify callback
    token:  a scalar value that bust be passed back and forth with the server
            to validate commands.

  responce:
    reply:  Verbal reply to user. Simpel forms are: ok, Unable to comply, working.
    error:  Optional. Explanation of failure
    cmd_id: returned from the request
    token:  New token to use

  event:
    event:  An unique event name (Must be a valid HTML tag id as well)
    state:  New state of the object of the event
    html:   Optional. HTML code update
    message: Optional. A text message update 
    token:  New token to use
    
    
\*----------------------------------------------------------------------------*/

$req['serverinfo']='all';
$req['token']=false;

//$req['fill']="sdkfjghsdjkfghsdlk vmhsdkfjlvnsdjæknvsdæjknbsdkjænbsjdfbnsdjkfbnksjdgnbskjdfnbsdnbkjsdnbvkjsdnbkjsdnbjksndfjkbnsdkjbnsdjkbnsdjkbnsdjbgnsd sjdfng sdfghsæ dhgj sdfgjsdh gæosjdghæosdhhhhhhhhhhhgasdnf æsdofngsædofdofgæsodfhgsæodfgsædo";

//sys_handler($req);

function sys_handler($req){

  static $sp;
  
  // Validate request
  if(!is_array($req))
    trigger_error("Event server call with mallformed or empty request", E_USER_ERROR);

  
  // Make websocket connection to server (Keep it open and let it close on exit)
  $headers=[
     "cookie: $_SERVER[HTTP_COOKIE_PARSE_RAW]"
    //,"user-agent: $_SERVER[HTTP_USER_AGENT]"
  ];

  if(!$sp) $sp=websocket_open('127.0.0.1',$headers);
  if(!$sp) trigger_error("Unable to connect to event server: $errstr ($errno)");
  
  // Send command and wait for an answer synchronously
  websocket_write($sp,json_encode($req,JSON_NUMERIC_CHECK | JSON_NUMERIC_CHECK));
  echo "Request:<br>".print_r($req,true) . "<br>";

  // Get reply
  $data=websocket_read($sp);
  echo "Response:<br>".print_r(json_decode($data,true),true) . "<br>";

  return json_decode($data,true);
  
}

// Stack opdater
// http://stackoverflow.com/questions/7160899/websocket-client-in-php
// http://stackoverflow.com/questions/22370966/connecting-to-websocket-with-php-client

function websocket_open($host="127.0.0.1",$headers=''){
  // Make websocket connection to server (Let it close on exit)
  // or socket pointer invalid!

    // Make websocket upgrade request header
    // Make a header for a http GET upgrade to websocket. End with double CR+LF
    // The key is only for the server to prove it i websocket aware. 
    // We know it is.

    // Generate a key (to convince server that the update is not random)
    $key=base64_encode(uniqid());
    
    $header = "GET / HTTP/1.1\r\n"
      ."Host: $host\r\n"
      ."pragma: no-cache\r\n"
      ."Upgrade: WebSocket\r\n"
      ."Connection: Upgrade\r\n"
      ."Sec-WebSocket-Key: $key\r\n"
      ."Sec-WebSocket-Version: 13\r\n";
    // Add extra headers  
    foreach($headers as $h) $header.=$h."\r\n";  
    // Add end of header marker
    $header.="\r\n";

echo "<pre>$header</pre>";      
    // Connect to server  
    $sp=fsockopen("127.0.0.1", 80, $errno, $errstr,1) 
      or die("Unable to connect to event server: $errstr ($errno)");
    // Set timeouts
    stream_set_timeout($sp,1,100);
   // stream_set_blocking($sp, false);
    //Request upgrade to websocket 
    fwrite($sp,$header )
      or die("Unable to send upgrade header to event server: $errstr ($errno)");
    
    // Read response into an assotiative array of headers. Fails if upgrade to ws failes.
    $reaponse_header=fread($sp, 1024);

    // Verify that server upgraded to websocket

    // status code 101 indicates that the WebSocket handshake has completed.
    if(!strpos($reaponse_header," 101 ") || !strpos($reaponse_header,'Sec-WebSocket-Accept: '))
      trigger_error("Event server did not accept to upgrade connection to websocket.".$reaponse_header, E_USER_ERROR);
      
    // The key we send is returned, concatenate with "258EAFA5-E914-47DA-95CA-C5AB0DC85B11"
    // and then base64-encoded. one can verify if one feels the need...
    echo "Connected to websocket server<br>";
  return $sp;
}


// Read websocket

// Read to the end of the message and store the rest as the next message.

/*Using hybi10 Decoding

  0                   1                   2                   3
      0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1
     +-+-+-+-+-------+-+-------------+-------------------------------+
     |F|R|R|R| opcode|M| Payload len |    Extended payload length    |
     |I|S|S|S|  (4)  |A|     (7)     |             (16/63)           |
     |N|V|V|V|       |S|             |   (if payload len==126/127)   |
     | |1|2|3|       |K|             |                               |
     +-+-+-+-+-------+-+-------------+ - - - - - - - - - - - - - - - +
     |     Extended payload length continued, if payload len == 127  |
     + - - - - - - - - - - - - - - - +-------------------------------+
     |                               |Masking-key, if MASK set to 1  |
     +-------------------------------+-------------------------------+
     | Masking-key (continued)       |          Payload Data         |
     +-------------------------------- - - - - - - - - - - - - - - - +
     :                     Payload Data continued ...                :
     + - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - +
     |                     Payload Data continued ...                |
     +---------------------------------------------------------------+

https://tools.ietf.org/rfc/rfc6455.txt

 http://tools.ietf.org/html/draft-ietf-hybi-thewebsocketprotocol-10#section-4.2



// Always sending binary messages 
// Always using masked data
// This one is done with a maximum of 32 bit lenght of data
// Application length are limited to 1GB to support small 32 bit system
// This can easily be changed.


// node_modules/ws crashes if sending unmasked data - test new wersion
*/
function websocket_write($sp, $data,$final=true){
  // Assamble header: FINal 0x80 | Opcode 0x02
  $header=chr(($final?0x80:0) | 0x02); // 0x02 binary

  // Mask 0x80 | payload length (0-125) 
  if(strlen($data)<126) $header.=chr(0x80 | strlen($data));  
  elseif (strlen($data)<0xFFFF) $header.=chr(0x80 | 126) . pack("n",strlen($data));
  else $header.=chr(0x80 | 127) . pack("N",0) . pack("N",strlen($data));

  // Add mask
  $mask=pack("N",rand(1,0x7FFFFFFF));       
  $header.=$mask;
  
  // Mask application data. 
  for($i = 0; $i < strlen($data); $i++)
    $data[$i]=chr(ord($data[$i]) ^ ord($mask[$i % 4]));
  
  fwrite($sp,$header.$data);    

  echo "Send:<br>";
  hex_dump($header.$data,"<br>");
}


function websocket_read($sp){
  $data="";

  do{
    // Read header
    $header=fread($sp,2);
    if(!$header) trigger_error("Reading header from websocket failed", E_USER_ERROR);
    $opcode = ord($header[0]) & 0x0F;
    $final = ord($header[0]) & 0x80;
    $masked = ord($header[1]) & 0x80;
    $payload_len = ord($header[1]) & 0x7F;
    
    // Get payload length extensions
    $ext_len=0;
    if($payload_len>125) $ext_len+=2;
    if($payload_len>126) $ext_len+=6;
    if($ext_len){
      $header=fread($sp,$ext_len);
      if(!$header) trigger_error("Reading header extension from websocket failed", E_USER_ERROR);
      // Set extented paylod length
      $payload_len=0;
      for($i=0;$i<$ext_len;$i++) 
        $payload_len += ord($header[$i]) << ($ext_len-$i)*8;
    }
    
    // Get Mask key
    if($masked){
      $mask=fread($sp,4);
      if(!$mask) trigger_error("Reading header mask from websocket failed", E_USER_ERROR);
    }
    
    // Get application data 
    $data_len=$payload_len-$ext_len-($masked?4:0);
    $frame_data=fread($sp,$data_len);
    if(!$frame_data) trigger_error("Reading from websocket failed", E_USER_ERROR);

    // Unmask data
    if($masked)
      for ($i = 0; $i < $data_len; $i++) 
        $data.= $frame_data[$i] ^ $mask[$i % 4];
    else    
      $data.= $frame_data;

    // If opcode 0 its a continuation of previous message. look for FINal
    // if opcode ping, send pong and continue to read
    
  }while(!$final);
    
  return $data;
}



?>
</body>
</html>
