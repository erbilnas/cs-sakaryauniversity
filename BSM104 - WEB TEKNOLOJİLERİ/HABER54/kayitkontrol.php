<?php
	require_once("connect.php");
	
	if($_POST["isim"] == "" || $_POST["email"] == "" || $_POST["parola"] == ""){
		header('Location: login.php');
	}
	
	$isim = mysql_real_escape_string($_POST["isim"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$parola = mysql_real_escape_string($_POST["parola"]);
	$foto = "img/uye/default.jpg";
	$yetki = 0;
	$s = mysql_num_rows(mysql_query("SELECT * FROM uye")) + 1;
	$md5parola = md5($parola);
	$session = $s.$md5parola;
	
	$email_check = mysql_num_rows(mysql_query("SELECT * FROM uye WHERE email='$email'"));
	
	if($email >= 1){
		echo "<script>alert('Aynı email ile 1 den fazla kayıt oluşturulamaz.');</script>";
		header('Location: login.php');
	}
	
	$sql = "insert into uye (ad, email, parola, foto, yetki, session) VALUES ('$isim', '$email', '$md5parola', '$foto', '$yetki', '$session')";
	
	if(mysql_query($sql)){
		echo "<script>alert('Üye kaydı oluşturuldu.');</script>";
		header('Location: index.php');
	}else{
		echo "<script>alert('Üye kaydı oluşturulamadı.');</script>";
		header('Location: login.php');
	}
	
	
	mysql_close($link);
?>