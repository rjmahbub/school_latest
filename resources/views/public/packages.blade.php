@extends('layouts.main_site')
@section('title','Packages')
@section('content')
<!--Page Title-->
<section class="page-title py-5 mt-5" style="background-image:url(/public/assets/plugins/main/images/background/9.jpg);">
	<div class="auto-container">
        <h2 class="text-white">Package Selection</h1>
		<ul class="bread-crumb clearfix">
			<li><a href="/">Home</a></li>
			<li class="text-secondary">Package</li>
		</ul>
	</div>
</section>
<!--End Page Title-->
@include('includes.packages')
@endsection