<?php

require_once "Configuration/DatabaseConnection1.php";


$sql="SELECT * FROM \"Ogrenci\" where \"adi\" Like '".$_POST['adi']."%'";

$result =pg_query($baglantiNo, $sql);

pg_close($baglantiNo);

$strXML= '<?xml version="1.0" encoding="UTF-8"?><ogrenciler>';
while ($row = pg_fetch_array($result))
{

    $strXML.= "<ogrenci><adi> ". $row['adi']."</adi><soyadi>".$row['soyadi']."</soyadi></ogrenci>";
}
$strXML.= '</ogrenciler>';
print ($strXML);


