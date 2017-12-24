<?php
	require_once("../connect.php");

	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=yorumlar');
	}else{
		
		$id = $_GET["i"];
		$sql = "DELETE FROM yorum WHERE id='$id';";

		if(mysql_query($sql)){
			header('Location: ../admin.php?a=yorumlar');
		}else{
			echo "<h1>Üye Silinemedi.</h1>";
			sleep(5);
			echo '<script>window.location="../admin.php?a=yorumlar";</script>';
		}
	}
?>