@extends('layouts.iframe')
@section('title','Send-Money')
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
        <li><a href="{{ route('cashInFormSuperAdmin') }}">Cash-In</a></li>
        <li><a class="active">Send Money</a></li>
        <li><a href="{{ route('cashoutHistory') }}">Withdraw Request</a></li>
        <li><a href="{{ route('statement') }}">Statement</a></li>
    </ul>
    <div class="card-body">
        <form id="SendMoneyForm" action="{{ route('SendMoney') }}" method="post">
            @csrf
            <ul><li class="text-danger">Minimum send-money 10 tk</li></ul>
            <div class="form-group">
                <label for="">Available Balance</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="text" value="{{ Auth::user()->balance }}" class="form-control" disabled>
                </div>
            </div>
            
            <div class="form-group">
                <label for="amount">Amount</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="number" name="amount" id="amount" min="100" max="{{ Auth::user()->balance }}" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" placeholder="send-money amount" required>
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="to_phone">Send to Phone-Number</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="number" name="to_phone" id="to_phone" min="11" value="{{ old('to_phone') }}" class="form-control @error('to_phone') is-invalid @enderror" placeholder="to phone number" required>
                    @error('to_phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Transaction Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" id="password" class="form-control pwd" placeholder="transaction password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
    $('#SendMoneyForm').submit(function(){
        $('.spinner_container').show();
    })
</script>
@endsection