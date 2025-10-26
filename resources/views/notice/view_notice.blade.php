@extends('layouts.site')
@section('title','Notice')
@section('content')
<div style="min-height:400px;" class="row">
    <div class="col-lg-9 pr-lg-0 mt-4 mx-auto">
        <div class="card">
            <div class="card-body">
                @if($notice)
                <h5><i class="fa fa-pen-nib"></i> {{ $notice->title }}</h5>
                <small>Published on : {{ $notice->created_at }}</small>
                <hr>
                {!! $notice->description !!}
                <hr>
                <h6>File Attachment</h6>
                <ol>
                    @for($i=1;$i<=5;$i++)
                    @php $p = 'file'.$i; @endphp
                    @if($notice->$p != null)
                    <li><a href="/public/uploads/{{ $prefix }}/notices/{{ $notice->$p }}" download>Download</a></li>
                    @endif
                    @endfor
                </ol>
                @else
                <h5 class="text-center">The notice not available!</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection