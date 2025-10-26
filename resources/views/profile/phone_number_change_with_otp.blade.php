@extends('layouts.master')
@section('content')
<div class="content-header p-1">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h5 class="m-0"></h5></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update profile information</div>
                <div class="card-body">
                    <form method="POST" action="/profile/update">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? auth()->user()->name }}" required>
                                @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">Select Relation</option>
                                    <option value="male" @if(Auth::user()->gender =="male") {{ "selected" }} @endif>Male</option>
                                    <option value="female" @if(Auth::user()->gender =="female") {{ "selected" }} @endif>Female</option>
                                    <option value="other" @if(Auth::user()->gender =="other") {{ "selected" }} @endif>Others</option>
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
                                <div class="d-flex">
                                    <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" onchange="if($('#phone').val() == '{{ auth()->user()->phone }}'){$('#otp,#otpDiv').hide()}else{$('#otp,#otpDiv').show()}" name="phone" value="{{ old('phone') ?? auth()->user()->phone }}" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');">
                                    <div id="otpDiv" style="width:125px;display:none;">
                                        <button id="GetOtp" class="btn border-secondary w-100" type="button" title="Get OTP">Get Code</button>
                                    </div>
                                </div>
                                <input style="display:none;" id="otp" type="number" class="form-control mt-2 @error('otp') is-invalid @enderror" name="email" placeholder="enter OTP code">
                                @error('otp')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? auth()->user()->email }}">
                                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#GetOtp').click(function(){
        $('#GetOtp').html('<i class="fa fa-sync fa-spin"></i>').attr('disabled',true);
        var number = $('#phone').val();
        $.ajax({
            url: "{{ route('OtpRequest') }}",
            type: 'post',
            data: {_token:'{{ csrf_token() }}', number:number },
            success: function(result){
                if(result == true){
                    $('#GetOtp').attr('disabled',false);
                    $('#GetOtp').text('Sent !');
                }else{
                    $('#GetOtp').attr('disabled',false);
                    $('#GetOtp').text('Try again');
                }
            },
            error: function(e){
                alert('error!');
            }
        });
    })
</script>
@endsection
