<?php
require_once("../connect.php");
$sid = $_COOKIE["SID"];


$target_dir = "../images/uye/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Dosyanin Formati - " . $check["mime"] . ".<br><br>";
        $uploadOk = 1;
    } else {
        echo "Dosya fotograf.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Dosya boyutu çok fazla.";
	sleep(3);
	echo '<script>window.location="../hesabim.php?a=foto";</script>';
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sadece jpg, gif, png ve jpeg formatinda dosya yükleyebilirsiniz.";
	sleep(3);
	echo '<script>window.location="../hesabim.php?a=foto";</script>';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Dosya yüklenemedi.";
	sleep(3);
	echo '<script>window.location="../hesabim.php?a=foto";</script>';
// if everything is ok, try to upload file
} else {
	$name = $_FILES["fileToUpload"]["tmp_name"];
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Fotoğraf başarılı bir şekilde yüklendi. Hesabım sayfasına yönlendiriliyorsunuz.";
		$sql = mysql_query("UPDATE uye SET foto='images/$target_file' WHERE session='$sid'");
		sleep(3);
		echo '<script>window.location="../hesabim.php?a=foto";</script>';
    } else {
        echo "Dosya yüklenirken hata oluştu.";
		sleep(3);
		echo '<script>window.location="../admin.php?a=foto";</script>';
    }
}
?>
