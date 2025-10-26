@extends('layouts.iframe')
@section('title','Fee Management')
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
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">FEE MANAGEMENT</div>
        <li><a href="{{ route('billReport') }}">Report</a></li>
        <li><a class="active">Make Bill</a></li>
    </ul>
    <div class="card-body">
        @if(session('success'))
            <div class="alert table-success" role="alert">Bill Added Successfully</div>
        @endif

        @if(session('fail'))
            <div class="alert table-danger" role="alert">Bill Added Failed</div>
        @endif
        <form action="{{ route('makeBill') }}" method="POST" style="max-width:700px;">
            @csrf
            <div class="row">
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div"> Class</div>
                    <div class="col-md-9 col-7 input_field">
                        <select name="class_id" id="class_id" class="input-shadow edutab @error('class_id') is-invalid @enderror" required>
                            <option value=''>Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div"> Group</div>
                    <div class="col-md-9 col-7 input_field">
                        <select name="grp_id" id="grp_id" class="input-shadow edutab @error('grp_id') is-invalid @enderror">
                            <option value="">Select Group</option>
                        </select>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div"> Session</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="session" id="session" class="input-shadow edutab" placeholder="session">
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div"> Details</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="details" class="input-shadow edutab" placeholder="details">
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div"> Amount</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="amount" class="input-shadow edutab" placeholder="amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info px-5">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection