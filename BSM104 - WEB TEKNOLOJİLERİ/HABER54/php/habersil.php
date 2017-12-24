<?php
	require_once("../connect.php");

	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=haberler');
	}else{
		
		$id = $_GET["i"];
		$sql = "DELETE FROM haber WHERE id='$id';";

		if(mysql_query($sql)){
			header('Location: ../admin.php?a=haberler');
		}else{
			echo "<h1>Haber Silinemedi.</h1>";
			sleep(5);
				echo '<script>window.location="../admin.php?a=haberler";</script>';
		}
	}
?>