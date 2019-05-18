<?php

	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>index1</title>
		<link rel="stylesheet"  type="text/css" href="CSS/Main.css" />
		<script>
			function listele()
			{

                xmlhttp = new XMLHttpRequest(); // readystate:0

				xmlhttp.onreadystatechange = function() //istek durumunu tutan readystate her değiştişinde 
				//bu fonksiyon tetikleniyor. readystate 0-4 arası değer alıyor. 4->istek sonucu 
				//istemci tarafından alındı.
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200)// status ile sunucunun isteğe 
					//verdiği yanıtın durumu tutuluyor. 200->kaynak bulundu ve istek başarılı olarak karşılandı
					// 404 -> kaynak bulunamadı, 304 -> get isteği ise ve değişiklk yoksa önbellekten al, 
					//500-> dahili sunucu hatası (sunucuda beklenmeyen bir durumla karşılaşıldı) 
					// 403 -> yetkisiz erişim
					{
						document.getElementById("ortaForm").innerHTML = xmlhttp.responseText;
						//istek sonucu gelen veriler xmlhttp.responseText değişkenine aktarılıyor ve
						//dom ile bu veriler sayfa yeniden güncellenmeden ortaform id değerine sahip
						//div içerisinde gösteriliyor.
					}
				}
				xmlhttp.open("GET", "1Ajax1.php", true);//istek ayarları yapılıyor. readystate:1
				xmlhttp.send(); //istek gönderiliyor. readystate:2
			}
		</script>

	</head>

	<body>

		<input style="" type="submit" id="gonder" value="Listele" onclick="listele();"/>

		<div id="ortaForm" style="margin-left: 200px; height: 200px; overflow-x: hidden; overflow-y: scroll;">

		
		</div>



	</body>
</html>

