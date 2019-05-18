<?php

require_once "Configuration/DatabaseConnection1.php";


//$sql="SELECT * FROM \"Ogrenci\" where \"ogrenciNo\" Like '".$_POST['ogrenciNo']."%'";
$sql="SELECT * FROM \"Ogrenci\" where \"ogrenciNo\" = '".$_POST['ogrenciNo']."'";


$result = pg_query($baglantiNo,$sql);

pg_close($baglantiNo);

if(pg_num_rows($result)!=0)
{


    $data= array ('sonuc'=>'1');
    //print_r($data);
}
else
{
    $data= array ('sonuc'=>'0');
    //print_r($data);

}

echo json_encode($data);

pg_free_result($result);
