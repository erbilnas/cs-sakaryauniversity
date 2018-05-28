<?php
	require_once("../connect.php");
	
	$baslik =  mysql_real_escape_string($_POST["baslik"]);
	$resim =  mysql_real_escape_string($_POST["resim"]);
	$kategori =  mysql_real_escape_string($_POST["kategori"]);
	$tarih =  mysql_real_escape_string($_POST["tarih"]);
	$metin =  mysql_real_escape_string($_POST["metin"]);

	$sql = "insert into haber (baslik, resim, kategori, tarih, metin) VALUES ('$baslik', '$resim', '$kategori', '$tarih', '$metin')";
	
	if(mysql_query($sql)){
		echo "<script>alert('Haber eklendi.');</script>";
		echo '<script>window.location="../admin.php?a=haberler";</script>';
	}else{
		echo "<script>alert('Haber eklenemedi.');</script>";
		echo '<script>window.location="../admin.php?a=haberekle";</script>';
	}
	
	
	mysql_close($link);
?>