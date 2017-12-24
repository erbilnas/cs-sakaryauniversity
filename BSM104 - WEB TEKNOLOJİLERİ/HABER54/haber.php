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
    <title>HABER 54 | Haberin bir numarali adresi</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/changelog.css" rel="stylesheet"><!--Kendi olusturdugumuz .css dosyasi>
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

	
	<section>

		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="blog-post-area">
						<div class="single-blog-post">
						<?php 
							if(!isset($_GET["id"])){
								echo '<script>window.location="index.php";</script>';
							}
							$id = mysql_real_escape_string($_GET["id"]);
							
							$sql = mysql_query("SELECT * FROM haber WHERE id='$id'");
							
							if($haber = mysql_fetch_array($sql)){
								echo '<h3>'.$haber["baslik"].'</h3>';
								echo '<div class="post-meta"><ul>';
								echo '<li><i class="fa fa-calendar"></i> '.$haber["tarih"].'</li>';
								echo '</ul></div>';
								
								echo '<a href=""><img src="images/'.$haber["resim"].'" alt=""></a>';
								echo '<p>'.$haber["metin"].'</p>';
							}else{
								echo '<script>window.location="index.php";</script></a>';
							}
						?>
							
						</div>
					</div><!--/blog-post-area-->

					<div class="response-area">
						<h2>YORUMLAR</h2>
						<ul class="media-list">
		
									<?php
										$haber_id = $_GET["id"];
										$sql = mysql_query("SELECT * FROM yorum WHERE haber_id='$haber_id' AND onay='1'");
										if(mysql_num_rows($sql) == 0){
											echo 'Yorum yok.';
										}else{
											while($yorum = mysql_fetch_array($sql)){
												echo '<li class="media">';
												echo '<div class="media-body">';
												echo '<ul class="sinlge-post-meta">';
												echo '<li><i class="fa fa-user"></i>'.$yorum["ad"].'</li>';
												echo '<li><i class="fa fa-calendar"></i> '.$yorum["tarih"].'</li>';
												echo '</ul>';
												echo '<p>'.$yorum["yorum"].'</p>';
												echo '</div>';
												echo '</li>';
											}
											
										}
									?>
							
						</ul>					
					</div><!--/Response-area-->
					<div class="replay-box">
						<div class="row">
							<div class="col-sm-4">
								<h2>Yorum birakin</h2>
								<?php 
									echo '<form name="yorum" action="php/yorumekle.php?i='.$id.'" method="post" onsubmit="return check_yorum()">';
								?>
								
									<div class="blank-arrow">
										<label>Isim</label>
									</div>
									<span>*</span>
									<input type="text" name="ad" placeholder="Isminizi giriniz">
									<div class="blank-arrow">
										<label>E-posta adresi</label>
									</div>
									<span>*</span>
									<input type="email" placeholder="E-posta adresinizi giriniz" name="email">
								
							</div>
							<div class="col-sm-8">
								<div class="text-area">
									<div class="blank-arrow">
									</div>
									<span>*</span>
									<label>Yorum</label>
									<textarea name="yorum" placeholder="Yorumunuzu buraya yaziniz" rows="11"></textarea>
									<input type="submit" class="btn" value="Gönder">
								</div>
								</form>
							</div>
						</div>
					</div><!--/Repaly Box-->
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
					<p class="pull-left">Copyright (C) 2017 Erbil Nas & Umut Tosun. All rights reserved.</p>
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
	 <script>
    	function check_yorum(){
    		var ad = document.forms["yorum"]["ad"].value;
    		var email = document.forms["yorum"]["email"].value;
    		var yorum = document.forms["yorum"]["yorum"].value;
    		
    		if (ad == "" || email == "" || yorum == "") {
				alert("Lütfen boş alan bırakmayınız.");
				return false;
			}
			
			
		}
		
    </script>
	
</body>
</html>