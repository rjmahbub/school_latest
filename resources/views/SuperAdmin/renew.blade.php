<?php
    $user = Auth::user();
    if(strtotime($inst->valid_till) > strtotime(now())){
        $extend = 'layouts.iframe';
    }else{
        $extend = 'layouts.inactive_dashboard';
    }
?>
@extends($extend)
@section('title','Website Renew')
@section('content')
<div class="card ml-2 mb-0">
    <ul id="iframeMenu" class="p-0 m-0">
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
            <ul id="iframeNavigation" class="mb-0">
                <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
            </ul>
        </div>
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">APPS ACCOUNT</div>
        <li><a href="{{ route('payment') }}">Payment</a></li>
        <li><a class="active">Renew</a></li>
        <li><a href="{{ route('statement') }}">Statement</a></li>
    </ul>
    <div class="card-body">
        <form id="cashoutForm" action="{{ route('InstituteRenew') }}" method="POST" style="max-width:700px;margin:auto;">
            @csrf
            <ul>
                <li class="text-danger">Renew price rate base on students number</li>
                <li class="text-danger">Minimum renew duration 1 Year</li>
            </ul>
            <div class="form-group">
                <label for="">Your Balance</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="text" value="{{ $user->balance }}" class="form-control" disabled>
                </div>
            </div>
            
            <div class="form-group">
                <label for="valid_till">Duration</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i style="font-size:24px;" class="fas fa-calendar-alt"></i></span>
                    </div>
                    <select class="custom-select @error('valid_till') is-invalid @enderror" id="valid_till" name="valid_till" required>
                        <option value="">Select option</option>
                        <option value="12" @if(old('valid_till') == '12') {{ 'selected' }} @endif>1 Year</option>
                        <option value="24" @if(old('valid_till') == '24') {{ 'selected' }} @endif>2 Years</option>
                        <option value="36" @if(old('valid_till') == '36') {{ 'selected' }} @endif>3 Years</option>
                        <option value="48" @if(old('valid_till') == '48') {{ 'selected' }} @endif>4 Years</option>
                        <option value="60" @if(old('valid_till') == '60') {{ 'selected' }} @endif>5 Years</option>
                    </select>
                    @error('valid_till')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="">Renew fee</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="text" id="renewPrice" class="form-control" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Enter Your Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i style="font-size:24px;" class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="password">
                </div>
            </div>
            <div class="modal-footer d-flex">
                    <div style="width:35px;height:35px;display:none;" class="spinner_container ml-3">
                        @include('includes.spinner')
                    </div>
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#cashoutForm').submit(function(){
        $('.spinner_container').show();
    })

    $('#valid_till,#package').change(function(){
        priceControl()
    })
    $(document).ready(function(){
        priceControl()
    })
    function priceControl(){
        var pp = {{ $renewPrice }};
        var rp = $('#valid_till option:selected').val() / 12;
        $('#renewPrice').val(parseFloat(pp * rp).toFixed(2));
    }
</script>
@endsection