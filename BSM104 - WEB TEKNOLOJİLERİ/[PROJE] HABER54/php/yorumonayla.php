<?php
	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=yorumlar');
	}
	require_once("../connect.php");
	$id = $_GET["i"];

	$sql = mysql_query("UPDATE yorum SET onay='1' WHERE id='$id'");

	if($sql){
		header('Location: ../admin.php?a=yorumlar');
	}else{
		echo "<script>alert('SQL hata.');</script>";
		echo '<script>window.location="../admin.php?a=yorumlar";</script>';
	}
	
?>

