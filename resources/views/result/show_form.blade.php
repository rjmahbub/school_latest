@extends('layouts.iframe')
@section('title','Result Show')
@section('content')
<div class="card ml-2">
    <ul id="iframeMenu" class="p-0 m-0">
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
            <ul id="iframeNavigation" class="mb-0">
                <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
            </ul>
        </div>
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title"><i class="fa fa-table text-secondary"></i> RESULT</div>
        <li><a href="{{ route('rp') }}">Publish Result</a></li>
        <li><a class="active">Result Show</a></li>
    </ul>
    <div class="card mb-0" style="background:#f4f6f9;">
        <div style="margin:20px;border:1px solid #ddd;">
            @include('includes.public_result')
        </div>
    </div>
</div>

@endsection