<?php
	require_once("../connect.php");
	
	$ad =  mysql_real_escape_string($_POST["ad"]);
	$email =  mysql_real_escape_string($_POST["email"]);
	$konu =  mysql_real_escape_string($_POST["konu"]);
	$mesaj = mysql_real_escape_string($_POST["mesaj"]);
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
	
	
	$sql = "insert into mail (ad, email, konu, tarih, mesaj, kullanici_id) VALUES ('$ad', '$email', '$konu', '$tarih', '$mesaj', '$kullanici_id')";
	
	if(mysql_query($sql)){
		echo "<script>alert('Mail gönderildi.');</script>";
		echo '<script>window.location="../index.php";</script>';
	}else{
		echo "<script>alert('Mail gönderilemedi.');</script>";
		echo '<script>window.location="../index.php";</script>';
	}
	
	
	mysql_close($link);
?>