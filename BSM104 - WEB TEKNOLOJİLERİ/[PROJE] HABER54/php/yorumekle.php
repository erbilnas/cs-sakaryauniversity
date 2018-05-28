<?php
	require_once("../connect.php");
	
	$ad =  mysql_real_escape_string($_POST["ad"]);
	$email =  mysql_real_escape_string($_POST["email"]);
	$yorum =  mysql_real_escape_string($_POST["yorum"]);
	$haber_id = $_GET["i"];
	$tarih = date('d F Y');
	
	if(isset($_COOKIE["SID"])){
		$sid = $_COOKIE["SID"];
		$s = mysql_query("select * from uye where session='$sid'");
		if($a = mysql_fetch_array($s)){
			$kullanici_id = $a["id"];
		}
	}else{
		$kullanici_id = 0;
	}
	
	
	$sql = "insert into yorum (ad, email, yorum, tarih, haber_id, kullanici_id) VALUES ('$ad', '$email', '$yorum', '$tarih', '$haber_id', '$kullanici_id')";
	
	if(mysql_query($sql)){
		echo "<script>alert('Yorum eklendi.');</script>";
		echo '<script>window.location="../haber.php?id='.$haber_id.'";</script>';
	}else{
		echo "<script>alert('Yorum eklenemedi.');</script>";
		echo '<script>window.location="../haber.php?id='.$haber_id.'";</script>';
	}
	
	
	mysql_close($link);
?>