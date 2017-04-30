<?php
	if(!isset($_COOKIE["ASID"])){
		header('Location: index.php');
	}
	
	require_once("connect.php");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HABER 54 | Haberin bir numaralı adresi</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/changelog.css" rel="stylesheet"><!--Kendi oluşturduğumuz .css dosyası>
	<!-->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +90 (264) 295 69 79 </a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> bf@sakarya.edu.tr</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
							<li><a href="https://www.facebook.com/erbilnas071"><i class="fa fa-facebook"></i></a></li>
								<li><a href="https://twitter.com/erbilnas?lang=en"><i class="fa fa-twitter"></i></a></li>
								<li><a href="https://plus.google.com/u/0/+erbilnas071"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/logo.png" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
							</div>
							<div class="btn-group">
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="cikis.php"><i class="fa fa-user"></i> Çıkış</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="admin.php?a=slider">Slider</a></li>
								<li><a href="admin.php?a=haberekle">Haber Ekle</a></li>
								<li><a href="admin.php?a=haberler">Haberler</a></li>
								<li><a href="admin.php?a=yorumonay">Yorum Onay</a></li>
								<li><a href="admin.php?a=yorumlar">Yorumlar</a></li>
								<li><a href="admin.php?a=uyeler">Üyeler</a></li>
								<li><a href="admin.php?a=upload">Upload</a></li>
								<li><a href="admin.php?a=mail">Mail</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section>
		<div class="container">
			<div class="row">
				<?php
					if(isset($_GET["a"])){
						if($_GET["a"] == "slider"){
							include "php/slider.php";
						}else if($_GET["a"] == "haberekle"){
							include "php/haberekle.php";
						}else if($_GET["a"] == "haberler"){
							include "php/haberler.php";
						}else if($_GET["a"] == "yorumonay"){
							include "php/yorumonay.php";
						}else if($_GET["a"] == "yorumlar"){
							include "php/yorumlar.php";
						}else if($_GET["a"] == "uyeler"){
							include "php/uyeler.php";
						}else if($_GET["a"] == "upload"){
							include "php/upload.php";
						}else if($_GET["a"] == "mail"){
							include "php/mailoku.php";
						}
					}else{
						include "php/slider.php";
					}
					
				?>
			</div>
		</div>
	</section>
	
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="companyinfo">
							<h2><span>HABER</span>54</h2>
							<p>Sakarya'nın adaletli, mert ve korkusuz en büyük haber kanalına hoşgeldiniz! Haberin doğrusu Haber54 ile takip edilir.</p>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="address">
							<img src="images/map.png" alt="" />
								<p>Sakarya Üniversitesi Bilgisayar ve Bilişim Bilimleri Fakültesi, 54187 Sakarya</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2017 Erbil Nas & Umut Tosun. All rights reserved.</p>
				</div>
			</div>
		</div>
	</footer><!--/Footer-->

    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php
	mysql_close($link);
?>