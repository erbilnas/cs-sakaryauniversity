<?php

/*
*
 *
 * ***
Güvenli olmayan kaynaklardan gelen verilerin sunucu tarafında doğrulanması ve filitrelenmesi uygulamaların
güvenliği açısından son derece önemlidir. 

Harici verilerin (form giriş verileri, çerezler, web servislerinin verileri,Veritabanı sorgu sonuçları, 
sunucu değişkenleri) her zaman filitrelenmesi gerekmektedir...


    filter_var() - Filters a single variable with a specified filter
    filter_var_array() - Filter several variables with the same or different filters
    filter_input - Get one input variable and filter it
    filter_input_array - Get several input variables and filter them with the same or different filters

*/

/*

 * iki tür filitre vardır
 * 1) Dogrulama(Validating): dogru mu degil mi? (tamsayı mı değil mi...)
 * 2) Sanitizing(sterilize etmek) : karakter katarı içerisindeki bazı karakterlerin kullanımına izin vermek/
 * ya da engellemek için kullanılır...
 *
 *
 * */

echo '<hr /><img src="FilitreBayraklari.png" /> <hr />';

$sayi = 123a;

echo "girilen sayi(int):". filter_var($sayi, FILTER_VALIDATE_INT); //sayi değişkeni int ise değeri aksi halde false döner...
echo '<hr />';
echo "e posta:".var_dump(filter_var('xy@zab.ccom', FILTER_VALIDATE_EMAIL));
 echo '<hr />';
echo (filter_var('http://xyz.com', FILTER_VALIDATE_URL));
 echo '<hr />';


 
 $var=258;

$int_options = array(
"options"=>array
  (
  "min_range"=>0,
  "max_range"=>256
  )
);

if(!filter_var($var, FILTER_VALIDATE_INT, $int_options))
  {
  echo("Tamsayi geçerli değil");
  }
else
  {
  echo "Tamsayı geçerli",$var;
  }
 
 echo '<hr />';
 
 /*
  Through this example i think you can better understand

    if ( !filter_has_var(INPUT_GET, 'email') ) {
        echo "Email Not Found";
    }else{
        echo "Email Found";
    }
    Output

    localhost/nanhe/test.php?email=1 //Email Found
    localhost/nanhe/test.php?email //Email Found
    http://localhost/nanhe/test.php //Email Not Found

Consider on second example

http://localhost/nanhe/test.php
$_GET['email']="info@nanhe.in";
if ( !filter_has_var(INPUT_GET, 'email') ) {
        echo "Email Not Found";
    }else{
        echo "Email Found";
    }
But output will be Email Not 
*/
 
 
if(!filter_has_var(INPUT_GET, "email")) //dönüş tipi bool; INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV
  {
  echo "\$_GET[email]...Boyle bir giriş yok";
  }
else
  {
  if (!filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL)) //INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV
    {
    echo "E posta adresi geçerli değil";
    }
  else
    {
    echo "E posta adresi geçerli";
    }
  }
  
  
   echo '<hr />';
  
  
  $filters = array
  (
  "name" => array
    (
    "filter"=>FILTER_SANITIZE_STRING
    ),
  "age" => array
    (
    "filter"=>FILTER_VALIDATE_INT,
    "options"=>array
      (
      "min_range"=>1,
      "max_range"=>120
      )
    ),
  "email"=> FILTER_VALIDATE_EMAIL
  );

$result = filter_input_array(INPUT_GET, $filters);

if (!$result["age"])
  {
  echo("Age must be a number between 1 and 120.<br>");
  }
elseif(!$result["email"])
  {
  echo("E-Mail is not valid.<br>");
  }
else
  {
  echo("User input is valid");
  }
  
     echo '<hr />';
  
  	// Şifre olarak: 1' OR '1'='1 girildiğinde doğrulama yapılmadığı için login yapılmış olur...
  
  $veri="<b> 1' OR '1'='1 </b > " ;
  
  echo $veri;
  
  echo '<hr />';
 
  require_once 'Genel/VeritabaniBaglantisi.php';
  echo "mysqli_real_escape_string:".mysqli_real_escape_string($baglantiNo,$veri); //Veritabani bağlantisi sonlandirilmadan önce kullanılmalı
  //NUL (ASCII 0), \n, \r, \, ', ", and Control-Z karakterlerinin ihmal edilmesin sağlar
  
  echo '<hr />';
  
  
  
  echo "FILTER_SANITIZE_STRING:", filter_var($veri,FILTER_SANITIZE_STRING);
    // FILTER_FLAG_NO_ENCODE_QUOTES - This flag does not encode quotes
    // FILTER_FLAG_STRIP_LOW - Strip characters with ASCII value below 32
    // FILTER_FLAG_STRIP_HIGH - Strip characters with ASCII value above 127
    // FILTER_FLAG_ENCODE_LOW - Encode characters with ASCII value below 32
    // FILTER_FLAG_ENCODE_HIGH - Encode characters with ASCII value above 127
    // FILTER_FLAG_ENCODE_AMP - Encode the & character to &amp;
	
	
	
	
  
echo '<hr /><img src="FilitreBayraklari1.png" /> <hr />'; 
echo '<hr /><img src="FilitreBayraklari2.png" /> <hr />'; 
  
 
 // Güveli olmayan kaynaklardan gelen veriler herzaman için:
 	
 //   Filter input.
 //   Escape output. (mysql_real_escape_string)
 	
  
  
  
?> 
