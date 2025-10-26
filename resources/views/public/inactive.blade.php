<?php $domain = $_GET['domain']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>@if($domain == 'inactive') Inactive @else Not Found @endif | {{ $domainName }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Stylesheets -->
	<link href="/public/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
    @if($domain == 'inactive')
    <!--domain not found-->
    <section class="py-5 container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <h3 class="text-center">{{ $domainName }}</h3>
                <p class="text-center text-danger mb-4">Your site is inactive!</p>
                <ul>
                    <li>আপনার ওয়েব-সাইট ক্রয়কৃত প্যাকেজের মেয়াদ উত্তীর্ণ হওয়ার কারণে ইন-অ্যাক্টিভে রয়েছে ।</li>
                    <li>অ্যাক্টিভ করতে চাইলে লগিন করে পেমেন্ট প্রোসেস সম্পন্ন করুন ।</li>
                    <li>অন্য কোন সমস্যা হলে দয়া করে যোগাযোগ করুন - 01789050186</li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-primary ml-5">Login Now</a>
            </div>
        </div>
    </section>
    <!--End domain not found-->
    @else
    <!--domain not found-->
    <section class="text-center py-5">
        <h3>{{ $domainName }}</h3>
        <p>The domain is not registered! <br> You can register this</p>
        <a href="https://{{ $mainDomain }}/subdomain-register?prefix={{ $prefix }}" class="btn btn-primary">Register Now</a>
    </section>
    <!--End domain not found-->
    @endif
</body>
</html>