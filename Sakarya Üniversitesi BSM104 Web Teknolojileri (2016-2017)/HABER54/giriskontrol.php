<?php
	require_once("connect.php");
	
	$email = mysql_real_escape_string($_POST["email"]);
	$parola = md5(mysql_real_escape_string($_POST["parola"]));
	
	$sql = "SELECT * FROM uye WHERE email='$email' AND parola='$parola'";
	$s = mysql_num_rows(mysql_query($sql));
	
	if($s >= 1){
		$kullanici = mysql_fetch_array(mysql_query($sql));
		
		if($kullanici["yetki"] == 1){
			if(isset($_POST['hatirla'])){
				setcookie("ASID", $kullanici["session"], time()+86400*30);
				header('Location: admin.php');
			}
		
			setcookie("ASID", $kullanici["session"]);
			header('Location: admin.php');
			
		}else{
			if(isset($_POST['hatirla'])){
				setcookie("SID", $kullanici["session"], time()+86400*30);
				header('Location: index.php');
			}
			setcookie("SID", $kullanici["session"]);
			header('Location: index.php');
		}
		
	}else{
		echo "<script>alert('Giris basarisiz. Giriş sayfasına yönlendiriliyorsunuz.');</script>";
		sleep(5);
		header('Location: login.php');
	}
	
	mysql_close($link);
?>