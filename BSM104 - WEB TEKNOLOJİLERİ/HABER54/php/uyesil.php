<?php
	require_once("../connect.php");

	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=uyeler');
	}else{
		
		$uyeid = $_GET["i"];
		$sql = "DELETE FROM uye WHERE id='$uyeid';";

		if(mysql_query($sql)){
			header('Location: ../admin.php?a=uyeler');
		}else{
			echo "<h1>Üye Silinemedi.</h1>";
			sleep(5);
				echo '<script>window.location="../admin.php?a=uyeler";</script>';
		}
	}
?>