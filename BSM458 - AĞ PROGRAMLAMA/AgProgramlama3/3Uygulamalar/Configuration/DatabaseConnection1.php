<?php

	$sunucu="127.0.0.1";
	$veritabani="OgrenciBilgiSistemi";
	$kullaniciAdi="LectureUser";
	$sifre="LecturePassword"; // Bu bilgileri daha güvenli bir klasörde (etc/...) saklayıp oradan erişmek daha güvenlidir.

	//$baglantiNo= pg_connect($sunucu, $kullaniciAdi, $sifre, $veritabani);
	$baglantiNo= pg_connect("host=$sunucu dbname=$veritabani user=$kullaniciAdi password=$sifre");
	//echo $baglantiNo;
	// Bağlantiyi doğrula
	if (pg_last_error())
	{
		echo "bağlantı başarısız... " . pg_last_error();
	}
