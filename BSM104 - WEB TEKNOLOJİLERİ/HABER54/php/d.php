<?php
	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=haberler');
	}
	require_once("../connect.php");
	$id = $_GET["i"];
	$baslik =  mysql_real_escape_string($_POST["baslik"]);
	$resim =  mysql_real_escape_string($_POST["resim"]);
	$kategori =  mysql_real_escape_string($_POST["kategori"]);
	$tarih =  mysql_real_escape_string($_POST["tarih"]);
	$metin =  mysql_real_escape_string($_POST["metin"]);
	
	$sql = mysql_query("UPDATE haber SET baslik='$baslik', resim='$resim', kategori='$kategori', tarih='$tarih', metin='$metin' WHERE id='$id'");

	if($sql){
		header('Location: ../admin.php?a=haberler');
	}else{
		echo "<script>alert('Haber düzeltilemedi.');</script>";
		echo '<script>window.location="../admin.php?a=haberler";</script>';
	}
	
?>