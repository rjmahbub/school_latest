@extends('layouts.site')
@section('content')
@section('title','Register')
@php
    if(!isset($getInfo)){
        return redirect('/register/step1');
    }
@endphp
<div class="page-content">
    <div class="wizard-v3-content">
        <div class="wizard-form">
            <div class="wizard-header">
                <h3 class="heading">User Registration System</h3>
                <p>Fill valid information to go next step</p>
            </div>
            <form class="form-register" action="{{ route('regMsg') }}" method="post">
                @csrf
                @if($request->usr == 5 || $request->usr == 6)
                <input type="hidden" name="member_id" value="{{ $getInfo->id }}">
                @endif
                @if($request->usr == 4)
                <input type="hidden" name="member_id" value="{{ $getInfo->id }}">
                @endif
                <input type="hidden" name="who" value="{{ $request->usr }}" required>
				<div id="form-total" role="application" class="wizard clearfix">
					<div class="steps clearfix">
                    <ul role="tablist">
							<li role="tab" aria-disabled="false" class="first current">
								<a id="form-total-t-0" aria-controls="form-total-p-0"><span class="current-info audible"> </span>
									<div class="title">
										<span class="step-icon"><i class="fa fa-info"></i></span>
										<span style="margin-left:-14px" class="step-text">Information</span>
									</div>
								</a>
							</li>
							<li role="tab" aria-disabled="false" class="first current">
								<a id="form-total-t-1" aria-controls="form-total-p-1">
									<div class="title">
										<span class="step-icon"><i class="fa fa-search"></i></span>
										<span style="margin-left:8px" class="step-text">Varify</span>
									</div>
								</a>
							</li>
							<li role="tab" class="last">
								<a id="form-total-t-3" aria-controls="form-total-p-3">
									<div class="title">
										<span class="step-icon"><i class="fa fa-user"></i></span>
										<span class="step-text">Confirm</span>
									</div>
								</a>
							</li>
						</ul>
					</div>
					<div class="content clearfix">
						<section id="form-total-p-0" role="tabpanel" aria-labelledby="form-total-h-0" class="body current" aria-hidden="false">
							<div class="inner">
								<h3>Verified Information:</h3>

								<div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $getInfo->full_name }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="father" class="col-md-4 col-form-label text-md-right">{{ __('Father') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $getInfo->father }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mother" class="col-md-4 col-form-label text-md-right">{{ __('Mother') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $getInfo->mother }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $getInfo->dob }}" disabled>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group row">
                                    <label for="user_type" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="@if($request->usr == 4) Teacher @elseif($request->usr == 5) Student @elseif($request->usr == 6) Guardian @endif" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nick_name" class="col-md-4 col-form-label text-md-right">{{ __('Profile Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="nick_name" type="nick_name" class="form-control @error('nick_name') is-invalid @enderror" name="nick_name" value="{{ old('nick_name') }}" autocomplete="nick_name" required>
                                        @error('nick_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

								<div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                                    <div class="col-md-6">
										<select name="gender" id="gender" class="custom-select st_inputs @error('gender') is-invalid @enderror" required>
											<option value="">Select...</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
											<option value="others">Others</option>
										</select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                                    <div class="col-md-6">
                                        <input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="@if($request->usr == 6){{ $getInfo->phone2 }}@else{{ $getInfo->phone }}@endif" autocomplete="phone" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'')" required>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" required>
                                    </div>
                                </div>
							</div>
						</section>
					</div>
					<div class="actions clearfix">
						<ul role="menu" aria-label="Pagination">
							<li style="margin-right:10px" aria-disabled="true"><a href="javascript:void(0)" onclick="window.history.back()">Previous</a></li>
							<li aria-hidden="false" aria-disabled="false"><input style="width:140px;height:45px;" class="btn btn-primary" type="submit" value="Submit"></li>
						</ul>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
@endsection