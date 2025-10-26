<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>@yield('title') | {{ $domainName }}</title>
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
    <script src="/public/assets/plugins/main/js/jquery.js"></script>
	<!-- Responsive -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<script src="/public/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<!-- Preloader -->
		<div class="preloader"></div>
		<!-- Header span -->
		<!-- Header Span --><span class="header-span"></span>
		<!-- Main Header-->
		<header class="main-header header-style-two">
			<div class="main-box">
				<div class="auto-container clearfix">
					<div class="logo-box py-2">
						<div class="logo">
							<a href="/"><img width="45" src="/public/assets/plugins/main/images/logo-2.svg" alt="" title=""></a>
						</div>
					</div>
					<!--Nav Box-->
					<div class="nav-outer clearfix pt-1">
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
									<li><a href="/">Home</a></li>
									<li @if(Request::path()=='domain-search')class="current"@endif><a href="{{ route('domainSearch') }}">Domain Search</a></li>
									<li @if(Request::path()=='documentation')class="current"@endif><a href="{{ route('documentation') }}">Documentation</a></li>
									<li @if(Request::path()=='affiliate')class="current"@endif><a href="{{ route('AffiliateRegisterForm') }}">Affiliate</a></li>
									<li><a style="max-width:200px;margin-left:20px;text-align:center;background: #ea0168;padding: 7px 20px;border-radius: 5px;color:white;" href="{{ route('login') }}">Login</a></li>
								</ul>
							</div>
						</nav>
						<!-- Main Menu End-->
						</div>
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
		
        @yield('content')

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
@include('sweetalert::alert')
</body>
</html>