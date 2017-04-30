<?php
	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=slider');
	}
	require_once("../connect.php");
	$id = $_GET["i"];
	$haber_id =  mysql_real_escape_string($_POST["haber_id"]);
	$foto =  mysql_real_escape_string($_POST["foto"]);
	$baslik =  mysql_real_escape_string($_POST["baslik"]);
	$ikinci =  mysql_real_escape_string($_POST["ikinci"]);
	$detay =  mysql_real_escape_string($_POST["detay"]);
	
	$sql = mysql_query("UPDATE slider SET haber_id='$haber_id', foto='$foto', baslik='$baslik', ikinci='$ikinci', detay='$detay' WHERE id='$id'");

	if($sql){
		header('Location: ../admin.php?a=slider');
	}else{
		echo "<script>alert('Slider düzeltilemedi.');</script>";
		echo '<script>window.location="../admin.php?a=slider";</script>';
	}
	
?>