<?php
$target_dir = "../images/";
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
        echo "Dosya fotoğraf.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Bu dosya çoktan bulunuyor.";
	sleep(3);
	echo '<script>window.location="../admin.php?a=upload";</script>';
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Dosya boyutu çok fazla.";
	sleep(3);
	echo '<script>window.location="../admin.php?a=upload";</script>';
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sadece jpg, gif, png ve jpeg formatında dosya yükleyebilirsiniz.";
	sleep(3);
	echo '<script>window.location="../admin.php?a=upload";</script>';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Dosya yüklenemedi.";
	sleep(3);
	echo '<script>window.location="../admin.php?a=upload";</script>';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Fotoğraf başarılı bir şekilde yüklendi. Admin sayfasına yönlendiriliyorsunuz.";
		sleep(3);
		echo '<script>window.location="../admin.php?a=upload";</script>';
    } else {
        echo "Dosya yüklenirken hata oluştu.";
		sleep(3);
		echo '<script>window.location="../admin.php?a=upload";</script>';
    }
}
?>
