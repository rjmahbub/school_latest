@extends('layouts.iframe')
@section('title','Cash-In SuperAdmin')
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
        <li><a class="active">Cash-In</a></li>
        <li><a href="{{ route('SendMoneyForm') }}">Send Money</a></li>
        <li><a href="{{ route('cashoutHistory') }}">Withdraw Request</a></li>
        <li><a href="{{ route('statement') }}">Statement</a></li>
    </ul>
    <div class="card-body">
        <div style="max-width:500px; margin:auto;">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Cash-In</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li class="text-danger">Minimum cash-in amount 100 taka</li>
                    </ul>
                    <form id="cashInForm" action="{{ route('cashInSuperAdmin') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Current Balance</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                                </div>
                                <input type="text" value="{{ Auth::user()->balance }}" class="form-control" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cashin_amount">Cash-In Amount</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                                </div>
                                <input type="number" name="cashin_amount" id="cashin_amount" min="100" max="100000" value="{{ old('cashin_amount') }}" class="form-control @error('cashin_amount') is-invalid @enderror" placeholder="cash-in amount" required>
                                @error('cashin_amount')
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
            $('#cashInForm').submit(function(){
                $('.spinner_container').show();
            })
        </script>
    </div>
</div>
@endsection