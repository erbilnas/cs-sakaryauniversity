<?php
	
	$link = mysql_connect("localhost", "root")or die("Mysql Bağlantısı kurulamadı.");

	mysql_select_db("proje", $link) or die("Veritabanına bağlanılamadı.");

	mysql_query("SET NAMES UTF8");

?>
