@php
    if($request->q){
        $extend = 'layouts.iframe';
    }else{
        $extend = 'layouts.main_site';
    }
@endphp
@extends($extend)
@section('title','Domain Register')
@section('content')
@if(!$request->q)
<!--Page Title-->
<section class="page-title py-5 mt-5" style="background-image:url(/public/assets/plugins/main/images/background/9.jpg);">
	<div class="auto-container">
		<h2 class="text-white">Website Registration</h2>
		<ul class="bread-crumb clearfix">
			<li><a href="/">Home</a></li>
			<li class="text-secondary">Register</li>
		</ul>
	</div>
</section>
<!--End Page Title-->
<style>
	label{color: black;font-weight: 600;margin-bottom:2px;}
	.card-title{color:rebeccapurple;}
</style>
@endif
<form id="SaveInstitute" class="form-horizontal mb-5" action="{{ route('DomainRegister') }}" method="POST">
	@csrf
	<div class="container">
		<div class="row mt-5">
			@auth()
			@if(Auth::user()->who == 7 && $request->refer && $request->q)
			<div class="col-lg-12">
				<h2 class="mb-4">Domain Register</h2>
				<input type="hidden" name="refer_user" value="{{ Auth::user()->id }}" required>
				<div class="form-group">
					<label for="refer_name">Refer User Name</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-university"></i></span>
						</div>
						<input type="text" value="{{ Auth::user()->nick_name }}" class="form-control @error('refer_name') is-invalid @enderror" disabled>
						@error('refer_name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
			</div>
			@endif
			@endauth
			<div class="col-lg-6">
				<div style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;" class="card card-info">
					<div class="card-header">
						<h3 class="card-title m-0">Institute Information</h3>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for="prefix">Website Name</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text p-1 p-lg-2 p-md-2"><i class="fas fa-globe"></i></span>
								</div>
								<div class="input-group-prepend">
									<span class="input-group-text p-1">www.</span>
								</div>
								<input style="text-transform:lowercase" type="text" name="prefix" id="prefix" value="@if(isset($_GET['prefix'])){{ $_GET['prefix'] }}@else{{ old('prefix') }}@endif" onkeypress="return /[0-9a-z]/i.test(event.key)" class="form-control @error('prefix') is-invalid @enderror" placeholder="sub-domain name" autocomplete="off" required>
								<div class="input-group-append">
									<span class="input-group-text p-1">.{{ $domainName }}</span>
								</div>
								@error('prefix')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="package">Package</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<?php
									if(isset($_GET['package'])){
										$package = $_GET['package'];
									}else{
										$package = '';
									}
								?>
								<select name="package" id="package" class="custom-select @error('package') is-invalid @enderror" required>
									<option value="">Select...</option>
									@foreach($packages as $package)
									<option value="{{ $package->id }}">{{ $package->name }}</option>
									@endforeach
								</select>
								@error('package')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="inst_name">Institute Name</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-university"></i></span>
								</div>
								<input type="text" name="inst_name" id="inst_name" value="{{ old('inst_name') }}" class="form-control @error('inst_name') is-invalid @enderror" placeholder="institute name" required>
								@error('inst_name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="inst_addr">Institute Address</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-map-marker"></i></span>
								</div>
								<input type="text" name="inst_addr" id="inst_addr" value="{{ old('inst_addr') }}" class="form-control @error('inst_addr') is-invalid @enderror" placeholder="institute address" required>
								@error('inst_addr')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="inst_phone">Institute Phone</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="number" name="inst_phone" id="inst_phone" value="{{ old('inst_phone') }}" class="form-control @error('inst_phone') is-invalid @enderror" placeholder="phone number" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" required>
								@error('inst_phone')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="inst_phone2">Institute Phone Alternative</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="text" name="inst_phone2" id="inst_phone2" value="{{ old('inst_phone2') }}" class="form-control @error('inst_phone2') is-invalid @enderror" placeholder="alternative phone number"  maxlength="11" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}">
								@error('inst_phone2')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="inst_email">Institute Email</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" name="inst_email" id="inst_email" value="{{ old('inst_email') }}" class="form-control @error('inst_email') is-invalid @enderror" placeholder="institute email address">
								@error('inst_email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title m-0">User Admin Information</h3>
					</div>
					<div class="card-body">

						<div class="form-group">
							<label for="nick_name">Profile Name</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="nick_name" id="nick_name" value="{{ old('nick_name') }}" class="form-control @error('nick_name') is-invalid @enderror" placeholder="short name" required>
								@error('nick_name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="full_name">Gender</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<select name="gender" id="gender" class="custom-select @error('gender') is-invalid @enderror">
									<option value="">Select...</option>
									<option value="male" @if(old('gender') == 'male') selected @endif>Male</option>
									<option value="female" @if(old('gender') == 'female') selected @endif>Female</option>
									<option value="others" @if(old('gender') == 'others') selected @endif>Others</option>
								</select>
								@error('gender')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="email">Email Address</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email address">
								@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="phone">Phone Number</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="phone number"  maxlength="11" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" required>
								@error('phone')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="password">Password</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="password" required>
								@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="confirm_password">Retype Password</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="retype password" required>
								@error('confirm_password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div id="AddInstSpinner" style="width:35px;height:35px;display:none;" class="ml-3">
							@include('includes.spinner')
						</div>
						<button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
$(document).ready(function(){
	$('#SaveInstitute').on('submit',(function(e){
		$('#AddInstSpinner').show();
	}));
});
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1200;  //time in ms, 1.2 second for example
	var $input = $('#prefix');

	//on keyup, start the countdown
	$input.on('keyup', function () {
		$('.fa-globe').addClass('fa-spin');
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	//on keydown, clear the countdown 
	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});

	function isValid(){
		$('#prefix').next().next().remove();
		$('#prefix').removeClass('is-invalid');
		$('#prefix').addClass('is-valid');
	}
	function isInvalid(){
		$('#prefix').next().next().remove();
		$('#prefix').addClass('is-invalid');
		$('#prefix').removeClass('is-valid');
	}
	function removeSpin(){
		$('.fa-globe').removeClass('fa-spin');
	}

	//user is "finished typing," do something
	function doneTyping () {
		if(!$('#prefix').val()){
			removeSpin();
			isInvalid();
			$('#prefix').parent().append("<span class='invalid-feedback' role='alert'><strong>please enter subdomain name</strong></span>");
		}else{
			var prefix = $input.val();
			$.ajax({
				url: "{{ route('checkSubdomain') }}",
				type: 'post',
				data: {_token:'{{ csrf_token() }}', prefix:''+prefix+''},
				success: function(result){
					if(result == false){
						removeSpin();
						isValid();
					}else{
						removeSpin();
						isInvalid();
						$('#prefix').parent().append("<span class='invalid-feedback' role='alert'><strong>the domain already taken! try another</strong></span>");
					}
				}
			});
		}
	}
</script>
@endsection
