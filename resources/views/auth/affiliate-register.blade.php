@extends('layouts.main_site')
@section('title','Affiliate')
@section('content')
<!--Page Title-->
<section class="page-title py-5 mt-5" style="background-image:url(/public/assets/plugins/main/images/background/9.jpg);">
	<div class="auto-container">
		<h2 class="text-white">Affiliate Program</h2>
		<ul class="bread-crumb clearfix">
			<li><a href="/">Home</a></li>
			<li class="text-secondary">Affiliate</li>
		</ul>
	</div>
</section>
<!--End Page Title-->

<style>
	label{color: black;font-weight: 600;margin-bottom:2px;}
	.card-title{color:rebeccapurple;}
</style>

<!-- Affiliate Program -->
<section class="about-section">
    <div class="anim-icons full-width"> <span class="icon icon-circle-blue wow fadeIn"></span> <span class="icon icon-dots wow fadeInleft"></span> <span class="icon icon-circle-1 wow zoomIn"></span> </div>
    <div class="auto-container">
        <div class="row">
            <!-- instruction Column -->
            <div class="content-column col-lg-6 col-md-12 col-sm-12">
                <div class="sec-title">
                    <h3 style="letter-spacing:0" class="title"><img src="/public/assets/plugins/main/images/welcome-rose.png" alt="">অ্যাফিলিয়েট প্রোগ্রামে স্বাগতম</h3>
                </div>
                <ul class="list-style-one">
                    <li>প্রতিটি সফল রেফারের জন্য আপনি প্যাকেজ মূল্যের 40% পাবেন ।</li>
                    <li>মাসে 5টির বেশি করতে পারলে পরবর্তী প্রতিটিতে কমিশন 10% বৃদ্ধি করা হবে ।</li>
                    <li>সর্বনিম্ন 2টি রেফার করলেই কেবল টাকা উত্তোলন করা যাবে ।</li>
                    <li>ক্লাইন্টের অ্যাকাউন্ট অ্যাকটিভ বা পেমেন্ট না করা পর্যন্ত আপনার অ্যাকাউন্টে কমিশন জমা হবে না ।</li>
                    <li>ক্লাইন্টের অ্যাকাউন্ট অবশ্যই পরিপূর্ণভাবে সেটআপ করে দিতে হবে ।</li>
                </ul>
            </div>
            <!-- register form Column -->
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title m-0">Affiliate Account Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('AffiliateRegister') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="refer_code">Refer Code</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="refer_code" id="refer_code" value="{{ old('refer_code') }}" class="form-control @error('refer_code') is-invalid @enderror" placeholder="refer code" required>
                                    @error('refer_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nick_name">Profile Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="nick_name" id="nick_name" value="{{ old('nick_name') }}" class="form-control @error('nick_name') is-invalid @enderror" placeholder="profile name" required>
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
                                        <option value="Male" @if(old('gender') == 'Male') selected @endif>Male</option>
                                        <option value="Female" @if(old('gender') == 'Female') selected @endif>Female</option>
                                        <option value="Others" @if(old('gender') == 'Others') selected @endif>Others</option>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Affiliate Program -->
@endsection