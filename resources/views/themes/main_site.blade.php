<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home | {{ $domainName }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Stylesheets -->
	<link href="/public/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/public/assets/plugins/main/css/style.css" rel="stylesheet">
	<link href="/public/assets/plugins/main/css/responsive.css" rel="stylesheet">
	<!--Color Switcher Mockup-->
	<link href="/public/assets/plugins/main/css/color-switcher-design.css" rel="stylesheet">
	<link rel="shortcut icon" href="/public/assets/img/icons/graduate-cap.svg" type="image/x-icon">
	<link rel="icon" href="/public/assets/img/icons/graduate-cap.svg" type="image/x-icon">
	<link rel="stylesheet" href="/public/assets/plugins/ghost-input/ghostinput.css">
	<!-- Responsive -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <script src="/public/assets/plugins/main/js/jquery.js"></script>
</head>
<body>
@yield('content')
<div class="page-wrapper">
	<!-- Preloader -->
	<div class="preloader"></div>
	<!-- Header span -->
	<!-- Main Header-->
	<header class="main-header">
		<div class="main-box">
			<div class="auto-container clearfix">
				<div class="logo-box">
					<div class="logo">
						<a href="/"><img width="40" src="/public/assets/plugins/main/images/logo.svg" alt="" title=""></a>
					</div>
				</div>
				<!--Nav Box-->
				<div class="nav-outer clearfix">
					<!--Mobile Navigation Toggler-->
					<div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
					<!-- Main Menu -->
					<nav class="main-menu navbar-expand-md navbar-light">
						<div class="navbar-header">
							<!-- Togg le Button -->
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="icon flaticon-menu-button"></span> </button>
						</div>
						<div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
							<ul class="navigation clearfix">
								<li class="current"><a href="/">Home</a></li>
								<li><a href="{{ route('domainSearch') }}">Domain Search</a></li>
								<li><a href="{{ route('documentation') }}">Documentation</a></li>
								<li><a href="{{ route('AffiliateRegisterForm') }}">Affiliate</a></li>
								<li><a style="max-width:200px;margin-left:20px;text-align:center;background: #ea0168;padding: 7px 20px;border-radius: 5px;color:white;" href="{{ route('login') }}">Login</a></li>
							</ul>
						</div>
					</nav>
					<!-- Main Menu End-->
				</div>
			</div>
		</div>
		<!-- Mobile Menu  -->
		<div class="mobile-menu">
			<div class="menu-backdrop"></div>
			<div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
			<!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
			<nav class="menu-box">
				<div class="nav-logo">
					<a href="/"><img width="40" src="/public/assets/plugins/main/images/logo-2.svg" alt="" title=""></a>
				</div>
				<ul class="navigation clearfix">
					<!--Keep This Empty / Menu will come through Javascript-->
				</ul>
			</nav>
		</div>
		<!-- End Mobile Menu -->
	</header>
	<!--End Main Header -->
	<!-- Banner Section -->
	<section class="banner-section">
		<div class="banner-carousel owl-carousel owl-theme">
			<!-- Slide Item -->
			<div class="slide-item" style="background-image: url(/public/assets/plugins/main/images/main-slider/1.jpg);">
				<div class="auto-container">
					<div class="content-box"> <span class="title"><span class="icon fa fa-headset"></span> helpline 01789050186</span>
						<h2>100% Secured <br> and Reliable</h2>
						<ul class="info-list">
							<li><i class="fa fa-headset"></i> With Customer Privecy</li>
						</ul>
						<div class="btn-box"><a href="#domain_search" class="theme-btn btn-style-two"><span class="btn-title">Register Now</span></a></div>
					</div>
				</div>
			</div>
			<!-- Slide Item -->
			<div class="slide-item" style="background-image: url(/public/assets/plugins/main/images/main-slider/2.jpg);">
				<div class="auto-container">
					<div class="content-box"> <span class="title"><span class="icon fa fa-headset"></span> helpline 01789050186</span>
						<h2>Easily Build Your <br> School/College Website</h2>
						<ul class="info-list">
							<li><i class="fa fa-headset"></i> full customer support</li>
						</ul>
						<div class="btn-box"><a href="#domain_search" class="theme-btn btn-style-two"><span class="btn-title">Register Now</span></a></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End Banner Section -->

	<!-- domain search Section -->
	@include('includes.domain_search')
	<!-- end domain search -->

	<!-- About Section -->
	<section class="about-section">
		<div class="anim-icons full-width"> <span class="icon icon-circle-blue wow fadeIn"></span> <span class="icon icon-dots wow fadeInleft"></span> <span class="icon icon-circle-1 wow zoomIn"></span> </div>
		<div class="auto-container">
			<div class="row">
				<!-- Content Column -->
				<div class="content-column col-lg-6 col-md-12 col-sm-12">
					<div class="inner-column">
						<div class="sec-title">
							<h2 class="title"><img src="/public/assets/plugins/main/images/welcome-rose.png" alt="">স্বাগতম</h2>
							<div class="text">প্রিয় ভিজিটর, আসসালামু আলাইকুম।</div>
						</div>
						<ul class="list-style-one">
							<li>আপনার শিক্ষা প্রতিষ্ঠানের কি ওয়েব সাইট দরকার?</li>
							<li>আপনি কি দক্ষ ওয়েব ডিজাইনার ও ডেভেলপার খুজছেন?</li>
							<li>আপনি কি ওয়েব ডিজাইনের ঝামেলা ছাড়াই ওয়েব সাইট চাচ্ছেন?</li>
							<li>আপনি কি স্বল্প খরচে অধিক ফিচার চাচ্ছেন?</li>
						</ul>
						<div class="text">আপনার সকল সমস্যা সমাধানে আমরা আছি আপনার পাশে। আপনি এখানে রেজিস্ট্রেশন করলেই আপনার প্রতিষ্ঠানের ওয়েব সাইট রেডী।</div>
						<div class="btn-box"><a href="#domain_search" class="theme-btn btn-style-three"><span class="btn-title">Register Now</span></a></div>
					</div>
				</div>
				<!-- Image Column -->
				<div class="image-column col-lg-6 col-md-12 col-sm-12">
					<div class="image-box">
						<figure class="image wow fadeIn"><img src="/public/assets/plugins/main/images/resource/about-img-1.jpg" alt=""></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End About Section -->
	
	<!-- Pricing Section -->
	@include('includes.packages')
	<!--End Pricing Section -->	

	<!-- Why Choose Us -->
	<section class="why-choose-us">
		<div class="auto-container">
			<div class="row">
				<div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
					<div class="inner-column">
						<div class="sec-title"> <span class="title">WHY CHOOSE US</span>
							<h2>কেন আমাদের এখানে জয়েন করবেন?</h2>
						</div>
						<ul class="list-style-one">
							<li>ডেভেলপের ঝামেলা নেই ।</li>
							<li>এক-কালীন অর্থ ইনভেষ্ট থেকে মুক্তি ।</li>
							<li>সাশ্রয়ী মূল্য ।</li>
							<li>নিয়মিত আপডেটের সুবিধা ।</li>
							<li>পূর্ণাঙ্গ ওয়েব সাইটসহ এ্যান্ড্রয়েড অ্যাপের সুবিধা ।</li>
						</ul>
						<div class="btn-box"> <a href="#domain_search" class="theme-btn btn-style-two"><span class="btn-title">Registration Now</span></a> </div>
					</div>
				</div>
				<div class="image-column col-lg-6 col-md-12 col-sm-12">
					<div class="image-box">
						<figure class="image"><img src="/public/assets/plugins/main/images/background/3.jpg" alt=""></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Why Choose Us -->

	@include('includes.documentation')

	<!-- Register Section -->
	<section class="register-section">
		<div class="auto-container">
			<div class="anim-icons full-width"> <span class="icon icon-circle-3 wow zoomIn"></span> </div>
			<div class="outer-box">
				<div class="row no-gutters">
					<div class="title-column col-lg-4 col-md-6 col-sm-12">
						<div class="inner">
							<div class="sec-title light">
								<div class="icon-box"><span class="icon flaticon-rocket-ship"></span></div>
								<h3 class="text-white">আপনার মতামত দিন</h3>
								<div class="text">অ্যাপের উন্নয়ন, সংযোজন, বিয়োজন তথা যেকোনো বিষয় সম্পর্কে আপনার পরামর্শ দিন। গ্রাহকের সন্তষ্টিই আমাদের লক্ষ্য।</div>
							</div>
						</div>
					</div>
					<!--Register Form-->
					<div class="register-form col-lg-8 col-md-6 col-sm-12">
						<div class="form-inner">
							<form id="opinion" onsubmit="return false" method="post" action="{{ route('opinion') }}">
								@csrf
								<div class="form-group"> <span class="icon fa fa-user"></span>
									<input type="text" name="full_name" placeholder="Full name" required>
								</div>
								<div class="form-group"> <span class="icon fa fa-envelope"></span>
									<input type="email" name="email" placeholder="Email address"> 
								</div>
								<div class="form-group"> <span class="icon fa fa-phone"></span>
									<input type="text" name="phone" placeholder="Phone">
								</div>
								<div class="form-group"> <span class="icon fa fa-edit"></span>
									<textarea name="message" id="compose" placeholder="Message" required></textarea>
								</div>
								<div class="form-group modal-footer">
									<div id="msg" style="display:none;"></div>
									<div id="loading" style="width:35px;display:none;">@include('includes.spinner')</div>
									<button type="submit" class="theme-btn btn-style-four"><span class="btn-title">Send Now</span></button>
								</div>
							</form>
							<script>
								$(document).ready(function (e) {
									$("#opinion").on('submit',(function(e) {
										e.preventDefault();
										$("#msg").empty();
										$('#loading').show();
										$.ajax({
											url: "{{ route('opinion') }}",
											type: "POST",
											data: new FormData(this),
											contentType: false,
											cache: false,
											processData:false,
											success: function(result){
												$('#loading').hide();
												$('#msg').show();
												$('#compose').empty();
												$("#msg").html(result);
											},
											error: function(){
												$('#loading').hide();
												$('#msg').show();
												$("#msg").html('<i class="fa fa-times-circle"></i> Error!!!');
											}
										})
									}))
								})
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End Register Section -->

	@include('includes.footer')

</div>
<!--End pagewrapper-->
<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-double-up"></span></div>
<script src="/public/assets/plugins/main/js/popper.min.js"></script>
<script src="/public/assets/plugins/ghost-input/jquery.ghostinput.js"></script>
<script src="/public/assets/plugins/main/js/bootstrap.min.js"></script>
<script src="/public/assets/plugins/main/js/jquery-ui.js"></script>
<script src="/public/assets/plugins/main/js/jquery.fancybox.js"></script>
<script src="/public/assets/plugins/main/js/appear.js"></script>
<script src="/public/assets/plugins/main/js/owl.js"></script>
<script src="/public/assets/plugins/main/js/jquery.countdown.js"></script>
<script src="/public/assets/plugins/main/js/wow.js"></script>
<script src="/public/assets/plugins/main/js/script.js"></script>
<!-- Color Setting -->
<script src="/public/assets/plugins/main/js/color-settings.js"></script>
<script type="text/javascript">
    $(function() {
        $("#ghost_writer_with_options").ghostInput({
            ghostText:".domain.com",
            ghostPlaceholder:".domain.com - Enter Sub Domain",
            ghostTextClass: "ghost-text"
        });
    });
</script>
@include('sweetalert::alert')
</body>
</html>