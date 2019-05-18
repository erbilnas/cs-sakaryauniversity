<?php

require_once "Configuration/DatabaseConnection1.php";

$sql="SELECT \"adi\", \"soyadi\" FROM \"Ogrenci\" where \"adi\" Like '".$_POST['adi']."%'";

$result =pg_query($baglantiNo, $sql);

pg_close($baglantiNo);


while ($row = pg_fetch_array($result))
{

    $str[] = array('adi' => $row['adi'], 'soyadi' => $row['soyadi']);
}

print json_encode($str);

