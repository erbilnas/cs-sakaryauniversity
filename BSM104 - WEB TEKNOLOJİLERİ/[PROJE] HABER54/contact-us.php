<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HABER 54 | İletişim</title>
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
								<li><a href="index.php">Ana Sayfa</a></li>
								<li><a href="contact-us.php" class="active">İletişim</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	 
	 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">		
			</div>    	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">İLETİŞİMDE KALIN</h2>
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<form id="iletisim" action="php/mail.php" class="contact-form row" name="iletisim" onsubmit="return check_iletisim()" method="post">
				            <div class="form-group col-md-6">
				                <input type="text" name="ad" class="form-control" required="required" placeholder="İsim">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" name="email" class="form-control" required="required" placeholder="E-posta">
				            </div>
				            <div class="form-group col-md-12">
				                <input type="text" name="konu" class="form-control" required="required" placeholder="Konu">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="mesaj" id="message" required="required" class="form-control" rows="8" placeholder="Mesajınız"></textarea>
				            </div>                        
				            <div class="form-group col-md-12">
				                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Kaydet">
				            </div>
				        </form>
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">İLETİŞİM BİLGİLERİ</h2>
	    				<address>
	    					<p>HABER54</p>
							<p>Bilgisayar ve Bilişim Bilimleri Fakültesi Haşim Gürdamar Binası 54187</p>
							<p>Serdivan / SAKARYA</p>
							<p>Tel: +90 (264) 295 69 79</p>
							<p>Fax: +90 (264) 295 69 78 </p>
							<p>Email: bf@sakarya.edu.tr</p>
	    				</address>
	    				<div class="social-networks">
	    					<h2 class="title text-center">SOSYAL AĞLARIMIZ</h2>
							<ul>
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-google-plus"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-youtube"></i></a>
								</li>
							</ul>
	    				</div>
	    			</div>
    			</div>    			
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->
	
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
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="js/gmaps.js"></script>
	<script src="js/contact.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
	
	<script>
    	function check_iletisim(){
			var ad = document.forms["iletisim"]["ad"].value;
			var email = document.forms["iletisim"]["email"].value;
			var konu = document.forms["iletisim"]["konu"].value;
			var mesaj = document.forms["iletisim"]["mesaj"].value;

			if (ad == "" || email == "" || konu == "" || mesaj == "") {
				alert("Lütfen isim kısmını boş bırakmayınız.");
				return false;
			}
			
    	}
    	
    </script>
	
</body>
</html>