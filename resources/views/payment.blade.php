<?php
    if(strtotime($inst->valid_till) > strtotime(now())){
        $extend = 'layouts.iframe';
    }else{
        $extend = 'layouts.inactive_dashboard';
    }
?>
@extends($extend)
@section('title','Cash-In')
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
        <li><a class="active">Payment</a></li>
        <li><a href="{{ route('InstituteRenewForm') }}">Renew</a></li>
        <li><a href="{{ route('statement') }}">Statement</a></li>
    </ul>
    <div class="card-body">
        <div>{{ $payment->html }}</div>
    </div>
</div>
@endsection