<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 01.05.2016
 * Time: 00:26
 */

//echo $_SERVER['QUERY_STRING']."<br>";
//echo $_SERVER['REQUEST_URI']."<br>";


/*$func = strtolower(trim(str_replace("/",".",$_SERVER['REQUEST_URI'])));
$func=explode(".",$func);
$func=arrtostr
$func=explode("?",$func);
echo end($func);*/


$parts = parse_url($_SERVER['REQUEST_URI']);
/*
foreach($parts as $part)
    echo $part."-";*/

parse_str($parts['query'], $query);
parse_str($parts['path'], $path);


echo "+--".$path."--+";

var_dump($path);

$func=key($path); path

echo "---".$func."---";

$func=explode("/",$func);


echo end($func);
//echo $path[0];

//echo $query['id'];
//echo $query['id'];

$data=array('param1' => $query['id']);

echo $data["param1"];

$id=$data["param1"];

$sql="SELECT \"ogrenciNo\", \"adi\", \"soyadi\" FROM \"Ogrenci\" WHERE \"ogrenciNo\"=\"$id\"";

echo $sql;
