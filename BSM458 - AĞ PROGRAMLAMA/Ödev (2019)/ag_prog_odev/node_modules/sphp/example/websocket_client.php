<?php
/*----------------------------------------------------------------------------*\
 Websocket client 
  
 By Paragi 2013, Simon Riget MIT license.
  
 This is a demonstration of a websocket clinet. Please add propper errorhandling 
 and such, if you use it for anythin else.
 
 If you find flaws in it, please tell me.
 
 
 Websockets use hybi10 frame encoding: 

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

  See: https://tools.ietf.org/rfc/rfc6455.txt
  or:  http://tools.ietf.org/html/draft-ietf-hybi-thewebsocketprotocol-10#section-4.2

  Notes about limits in this code:
    Using binary transfer mode
    Maximum of 32 bit lenght of data
    Application length are limited to 1GB to support small 32 bit system
  
\*----------------------------------------------------------------------------*/

function hex_dump($data, $newline="\n")
{
  // Make translation strings for character view
  $from = '';
  $to = '';
  for ($i=0; $i<=0xFF; $i++){
    $from.=chr($i);
    $to.=($i >= 0x20 && $i <= 0x7E) ? chr($i) : ".";
  }
  // Break up in chunks and translate
  $hex = str_split(bin2hex($data),32);
  $chars = str_split(strtr($data, $from, $to), 16);

  // display
  $offset = 0;
  foreach ($hex as $i => $line){
    echo sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2));
    echo " [" . $chars[$i] . "]</br>\n";
    $offset += 16;
  }
}

/*----------------------------------------------------------------------------*\
  Open websocket (url[,error string pointer])
  
  Make a connection to the websocket server.
  
  Return: on succes: a file pointer to the socket. 
\*----------------------------------------------------------------------------*/
function websocket_open($url="127.0.0.1",&$err=''){
  // Generate a key for the server to prove it i websocket aware. 
  $key=base64_encode(uniqid());
  
  // Make a GET header for upgrade request to websocket.
  $query=parse_url($url);
  $header="GET "
    .(isset($query['path']) ? "$query[path]" : "")
    .(isset($query['query']) ? "?$query[query]" : "")
    ." HTTP/1.1\r\nHost: "
    .(isset($query['scheme']) ? "$query[scheme]://" : "")
    .(isset($query['host']) ? "$query[host]" : "127.0.0.1")
    .(isset($query['port']) ? ":$query[port]" : "")
    ."\r\npragma: no-cache\r\n"
    ."cache-control: no-cache\r\n"
    ."Upgrade: WebSocket\r\n"
    ."Connection: Upgrade\r\n"
    ."Sec-WebSocket-Key: $key\r\n"
    ."Sec-WebSocket-Version: 13\r\n"
    .(isset($_SERVER['HTTP_COOKIE']) ? "cookie: $_SERVER[HTTP_COOKIE]\r\n": "")
    ."\r\n";

  // Connect to server  
  do{
    $sp=fsockopen((isset($query['scheme']) ? "$query[scheme]://" : "")
      .$query['host'],$query['port'], $errno, $errstr,1); 
    if(!$sp) break;

    // Set timeouts
    stream_set_timeout($sp,3,100);
    // stream_set_blocking($sp, false);
   
    //Request upgrade to websocket 
    $len=fwrite($sp,$header);
    if(!$len) break;
    
    // Read response into an assotiative array of headers. Fails if upgrade to ws failes.
    $reaponse_header=fread($sp, 1024);
  }while(false);

  // Errors
  if(!$sp) 
    $err="Unable to connect to event server: $errstr ($errno)";
  elseif(!$len) 
    $err="Unable to send upgrade header to event server: $errstr ($errno)";
  elseif(!strpos($reaponse_header," 101 ") 
         || !strpos($reaponse_header,'Sec-WebSocket-Accept: '))
    $err="Event server did not accept to upgrade connection to websocket."
        .$reaponse_header;

  if($err){
    @fclose($sp);
    return false;
  }    
  return $sp;
}

/*----------------------------------------------------------------------------*\
  Write to websocket (<socket file pointer>, <data to send> [,<final part>] )

  Protocol options are fixed to:
  - Sending data in binary mode
  - Always using masked data
  
  return succes
\*----------------------------------------------------------------------------*/
function websocket_write($sp, $data,$final=true){
  // Assamble header: FINal 0x80 | Opcode 0x02
  $header=chr(($final?0x80:0) | 0x02); // 0x02 binary

  // Mask 0x80 | payload length (0-125) 
  if(strlen($data)<126) $header.=chr(0x80 | strlen($data));  
  elseif (strlen($data)<0xFFFF) $header.=chr(0x80 | 126) . pack("n",strlen($data));
  elseif(PHP_INT_SIZE>4) // 64 bit 
    $header.=chr(0x80 | 127) . pack("Q",strlen($data));
  else  // 32 bit (pack Q dosen't work)
    $header.=chr(0x80 | 127) . pack("N",0) . pack("N",strlen($data));

  // Make a random mask
  $mask=pack("N",rand(1,0x7FFFFFFF));       
  $header.=$mask;
  
  // Apply mask to data
  for($i = 0; $i < strlen($data); $i++)
    $data[$i]=chr(ord($data[$i]) ^ ord($mask[$i % 4]));
  
  return fwrite($sp,$header.$data);    
}

/*----------------------------------------------------------------------------*\
  Read websocket(<socket file pointer> [[,<wait for end>], error string pointer])

  if wait_for_end is set, all messages send from the server are buffered and 
  returned as one coherent string, when the final message fragment are recieved.
  Otherwise each message fragment are returned.
  
  Pings are answered silently
\*----------------------------------------------------------------------------*/
function websocket_read($sp,$wait_for_end=true,&$err=''){
  $out_buffer="";

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
      $ext=fread($sp,$ext_len);
      if(!$ext) trigger_error("Reading header extension from websocket failed", E_USER_ERROR);

      // Set extented paylod length
      $payload_len=$ext_len;
      for($i=0;$i<$ext_len;$i++)
        $payload_len += ord($ext[$i]) << ($ext_len-$i-1)*8;
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

    // if opcode ping, reuse headers to send a pong and continue to read
    if($opcode==9){
      // Assamble header: FINal 0x80 | Opcode 0x02
      $header[0]=chr(($final?0x80:0) | 0x0A); // 0x0A Pong
      fwrite($sp,$header.$ext.$mask.$frame_data);
      
    // Recieve and unmask data
    }elseif($opcode<9){
      $data="";
      if($masked)
        for ($i = 0; $i < $data_len; $i++) 
          $data.= $frame_data[$i] ^ $mask[$i % 4];
      else    
        $data.= $frame_data;
      $out_buffer.=$data;
    }
    
    // wait for Final 
  }while($wait_for_end && !$final);
    
  return $out_buffer;
}
?>
