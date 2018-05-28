<?php
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
							
								<?php
									if(isset($_COOKIE["SID"])){
										$sid = $_COOKIE["SID"];
										$sql = mysql_query("SELECT * FROM uye WHERE session='$sid'");
										
										while($a = mysql_fetch_array($sql)){
											if($a){
												echo '<li><a href="hesabim.php">'.$a["ad"].'</a></li>';
												echo '<li><a href="cikis.php"><i class="fa fa-lock"></i> Çıkış</a></li>';
											}else{
												setcookie("SID", "", time()-3600);
												echo '<script>window.location="index.php";</script>';
											}
										}
										
									}else if(isset($_COOKIE["ASID"])){
										$sid = $_COOKIE["ASID"];
										$sql = mysql_query("SELECT * FROM uye WHERE session='$sid'");
										
										while($a = mysql_fetch_array($sql)){
											if($a){
												echo '<li><a href="admin.php">'.$a["ad"].'</a></li>';
												echo '<li><a href="cikis.php"><i class="fa fa-lock"></i> Çıkış</a></li>';
											}else{
												setcookie("ASID", "", time()-3600);
												echo '<script>window.location="index.php";</script>';
											}
										}
									}else{
										echo '<li><a href="login.php"><i class="fa fa-lock"></i> Giriş Yap/Üye Ol</a></li>';
									}
								
								?>
								
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
								<li><a href="index.php" class="active">Ana Sayfa</a></li>
								<li><a href="contact-us.php">İletişim</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
							<li data-target="#slider-carousel" data-slide-to="3"></li>
						</ol>
						
						<div class="carousel-inner">
								<?php
									$s = mysql_query("SELECT * FROM slider LIMIT 1");
								
									if($slider = mysql_fetch_array($s)){
										
										echo '<div class="item active">';
										echo '<div class="col-sm-6">';
										echo '<h1><span>'.$slider["baslik"].'</span></h1>';
										echo '<h2>'.$slider["ikinci"].'</h2>';
										echo '<p>'.$slider["detay"].'</p>';
										echo '<a href="haber.php?id='.$slider["haber_id"].'" class="btn btn-default get">Şimdi oku</a></a>';
										echo '</div>';
										echo '<div class="col-sm-6">';
										echo '<img src="images/'.$slider["foto"].'" class="girl img-responsive" alt="" />';
										echo '</div>';
										echo '</div>';
									}
									
									$sql = mysql_query("SELECT * FROM slider LIMIT 1,3");
									
									while($slider = mysql_fetch_array($sql)){
										echo '<div class="item">';
										echo '<div class="col-sm-6">';
										echo '<h1><span>'.$slider["baslik"].'</span></h1>';
										echo '<h2>'.$slider["ikinci"].'</h2>';
										echo '<p>'.$slider["detay"].'</p>';
										echo '<a href="haber.php?id='.$slider["haber_id"].'" class="btn btn-default get">Şimdi oku</a>';
										echo '</div>';
										echo '<div class="col-sm-6">';
										echo '<img src="images/'.$slider["foto"].'" class="girl img-responsive" alt="" />';
										echo '</div>';
										echo '</div>';
									}

								?>							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-sm-offset-1">
					<div class="blog-post-area">
						<h2 class="title text-center"> EN SON HABERLER</h2>
						
						<?php
						
							if(!isset($_GET["s"])){
								$s = 1;
							}else{
								$s = $_GET["s"];
							}

							$sorgu = mysql_query("select * from haber");
							$limit = 5; //Kayıtlar kaçar kaçar listelenecek
							$kayitSayisi = mysql_num_rows($sorgu); //Toplam Kayıt Sayısı
							$sayfaSayisi = ceil($kayitSayisi/$limit); //Toplam Sayfa Sayısı
							$baslangic = ($s*$limit)-$limit; //Hangi kayıttan başlanacak
						
							$sorgu = mysql_query("select * from haber order by id desc limit $baslangic,$limit");
							
							while($kayit=mysql_fetch_array($sorgu)){
								echo '<div class="single-blog-post">';
								echo '<h3>'.$kayit["baslik"].'</h3>';
								echo '<div class="post-meta">';
								echo '<ul>';
								echo '<li><i class="fa fa-calendar"></i> '.$kayit["tarih"].'</li>';
								echo '</ul>';
								echo '</div>';
								echo '<a href="haber.php?id='.$kayit["id"].'">';
								echo '<img src="images/'.$kayit["resim"].'" alt="">';
								echo '</a>';
								echo '<p>'.substr($kayit["metin"], 0, 350).'</p>';
								echo '<a  class="btn btn-primary" href="haber.php?id='.$kayit["id"].'">Okumaya devam et</a>';
								echo '</div>';
								
							}
						
						    if ($sayfaSayisi>1){ //1'den fazla kayıt varsa
								echo '<div class="pagination-area">';
								echo '<ul class="pagination">';
								for ($i=1;$i<=$sayfaSayisi;$i++){
									if ($s==$i){ 
										echo '<li><a href="index.php?s='.$s.'" class="active">'.$s.'</a></li>';
									}else{
										echo '<li><a href="index.php?s='.$i.'">'.$i.'</a></li>';
									}
								}
								
								if($s < $sayfaSayisi){
									$next = $s+1;
									echo '<li><a href="index.php?s='.$next.'"><i class="fa fa-angle-double-right"></i></a></li>';
								}

								echo '</ul>';
								echo '</div>';
							}
						
						?>

								
					
					</div>
				</div>
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