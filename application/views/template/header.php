<?php 
if(uri_string() == "register") {
	$loginRedirect = "";
} else {
	$loginRedirect = site_url(uri_string());
}

if(uri_string() == "login") {
	$registerRedirect = "";
}else {
	$registerRedirect = site_url(uri_string());
}
?>

<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="en">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
<head>


	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<title><?=(@$meta["title"]) ? $meta["title"] : 'Bir İmza Atın !'?></title>
	<meta name="description" content="<?=(@$meta["description"]) ? $meta["description"] : 'Bir İmza Atın !'?>">

	<base href="<?=site_url();?>" >

	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	
	<?php if(@$meta["campaign"]) { ?>
	<meta property="og:url"                content="<?=base_url(uri_string());?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?=(@$meta["title"]) ? $meta["title"] : 'Bir İmza Atın !'?>" />
	<meta property="og:description"        content="<?=(@$meta["description"]) ? @$meta["description"] : 'Bir İmza Atın !'?>" />
	<meta property="og:image"              content="<?=base_url(campaign_image_link(@$meta["campaign"]["image"],"large"))?>" />

	<?php } ?>
	
	<!-- CSS
	================================================== -->
	<!-- Base + Vendors CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fonts/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="css/fonts/entypo/css/entypo.css">
	<link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css" media="screen">
	<link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css" media="screen">
	<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" media="screen">
	<link rel="stylesheet" href="vendor/flexslider/flexslider.css" media="screen">
	<link rel="stylesheet" href="vendor/job-manager/frontend.css" media="screen">

	<!-- Theme CSS-->
	<link rel="stylesheet" href="css/theme.min.css">
	<link rel="stylesheet" href="css/theme-elements.min.css">
	<link rel="stylesheet" href="css/animate.min.css">
   

	<!-- Head Libs -->
	<script src="vendor/modernizr.js"></script>

	
	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="images/favicons/favicon.ico">
	<link rel="apple-touch-icon" sizes="120x120" href="images/favicons/favicon-120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/favicons/favicon-152.png">
	
	<script src="vendor/jquery-1.11.0.min.js"></script>
	<script src="vendor/jquery-migrate-1.2.1.min.js"></script>
	<script src="vendor/bootstrap.js"></script>
	<script src="vendor/jquery.flexnav.min.js"></script>
	<script src="vendor/jquery.hoverIntent.minified.js"></script>
	<script src="vendor/jquery.flickrfeed.js"></script>
	<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
	<script src="vendor/owl-carousel/owl.carousel.min.js"></script>
	<script src="vendor/jquery.fitvids.js"></script>
	<script src="vendor/jquery.appear.js"></script>
	<script src="vendor/jquery.stellar.min.js"></script>
	<script src="vendor/flexslider/jquery.flexslider-min.js"></script>
	<script src="vendor/jquery.countTo.js"></script>

	<!-- Newsletter Form -->
	<script src="vendor/jquery.validate.js"></script>
	<script src="js/newsletter.js"></script>

	<script type="text/javascript">
		$(function(){
			var active ="<?=@$active?>";
			$("#"+active).addClass("active");
		});
	</script>
	
	
</head>
<body>

	<div class="site-wrapper">

		<!-- Header -->
		<header class="header header-menu-fullw">

			<!-- Header Top Bar -->
			<div class="header-top">
				<div class="container">
					<div class="header-top-left">
						<button class="btn btn-sm btn-default menu-link menu-link__secondary">
							<i class="fa fa-bars"></i>
						</button>
						<div class="menu-container">
							<ul class="header-top-nav header-top-nav__secondary">
								<li><a href="<?=get_social_link("twitter")?>"><i class="fa fa-twitter"></i> <span class="nav-label">Twitter</span></a></li>
								<li><a href="<?=get_social_link("facebook")?>"><i class="fa fa-facebook"></i> <span class="nav-label">Facebook</span></a></li>
								<li><a href="<?=get_social_link("google")?>"><i class="fa fa-google-plus"></i> <span class="nav-label">Google+</span></a></li>
								<li><a href="<?=get_social_link("pinterest")?>"><i class="fa fa-pinterest"></i> <span class="nav-label">Pinterest</span></a></li>
								<li><a href="<?=get_social_link("instagram")?>"><i class="fa fa-instagram"></i> <span class="nav-label">Instagram</span></a></li>
								<li><a href="<?=get_social_link("rss")?>"><i class="fa fa-rss"></i> <span class="nav-label">RSS Feed</span></a></li>
							</ul>
						</div>
					</div>
					<div class="header-top-right">
						<button class="btn btn-sm btn-default menu-link menu-link__tertiary">
							<i class="fa fa-user"></i>
						</button>
						<div class="menu-container">
							<ul class="header-top-nav header-top-nav__tertiary">
							<li><a href="start"><i class="fa fa-pencil"></i> İmza Kampanyası Başlat</a></li>
                            <?php 
                            if(!$this->session->userdata("id")){
                            ?>
								<li><a href="register?redirect=<?=$registerRedirect?>"><i class="fa fa-user-plus"></i> KAYIT OL</a></li>
								<li><a href="login?redirect=<?=$loginRedirect?>"><i class="fa fa-sign-in"></i> GİRİŞ YAP</a></li>
                            <?php } ?>
                            <?php 
                            if($this->session->userdata("id")){
                            ?>
							
                            <li><a href="<?=site_url('profile/'.$this->session->userdata('id'))?>"><img width="30"  src="<?=profile_link($this->session->userdata('picture'),"small")?>" alt=""></i> <?=$this->session->userdata('first_name')." ".$this->session->userdata('last_name')?></a></li>
                            <li><a target="_self" href="logout"><i class="fa fa-sign-out"></i> ÇIKIŞ YAP</a></li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Header Top Bar / End -->
			
			<div class="header-main">
				<div class="container">
					<!-- Logo -->
					<div class="logo">
						<a href="<?=site_url()?>"><img src="images/logo.png" alt="Handyman"></a>
						<!-- <h1><a href="index.html"><span>Handy</span>Man</a></h1> -->
					</div>
					<!-- Logo / End -->

					<button type="button" class="navbar-toggle">
						<i class="fa fa-bars"></i>
					</button>

					<!-- Navigation -->
					<nav class="nav-main">
						<div class="nav-main-inner">
							<ul data-breakpoint="992" class="flexnav">
								<li id="homepage"><a href="<?=base_url()?>">ANASAYFA</a></li>
								<li id="about"><a href="<?=base_url("about")?>">HAKKIMIZDA</a></li>
								<li id="contact"><a href="<?=base_url("contact")?>">İLETİŞİM</a></li>
								<li id="faq"><a href="<?=base_url("frequently-asked-questions")?>">SIKÇA SORULAN SORULAR</a></li>
								
							</ul>
						</div>
					</nav>
					<!-- Navigation / End -->

				</div>
			</div>
			
		</header>
		
		<!-- Header / End -->