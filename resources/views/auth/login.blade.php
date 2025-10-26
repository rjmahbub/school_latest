@php
    if($prefix == $prefixMain){
        $extend = 'layouts.main_site';
    }else{
        $extend = 'layouts.site';
    }
@endphp
@extends($extend)
@section('title','Login')
@section('content')
<div style="max-width:450px;margin:auto;" class="justify-content-center my-5 pt-5 pt-lg-0">
    <div class="card">
        <h4 class="card-header">{{ __('Login') }}</h4>
        <div class="card-body text-center">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="number" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter mobile number" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="phone" required autofocus>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="enter password" autocomplete="current-password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary px-5">Login</button>
            </form>
            <br>
            <br>
            <a class="btn btn-link" href="{{ route('forgetPasswordForm') }}">Forgot Password?</a>
            @if($prefix !== $prefixMain)
            <hr>
            <a href="{{ route('register') }}" class="btn btn-success px-5">Registration</a>
            @endif
        </div>
    </div>
</div>
@endsection
