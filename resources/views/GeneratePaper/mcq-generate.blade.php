@extends('layouts.iframe')
@section('title','MCQ Generate')
@section('content')
<style>
    a{color:initial;}
    ul#setupMenu{display:flex;}
    ul#setupMenu>li{list-style:none;cursor: pointer;padding:9px 10px;border-bottom:1px solid #cacedc}
    ul#setupMenu>li.active{border: 1px solid #e0dee6;border-bottom: none;}
</style>

<div class="col-lg-12">
    <div style="background:#f4f6f9;" class="card">
        <ul id="setupMenu" class="p-0 m-0">
            <li><a style="padding:11px 0px;" href="{{ route('AddMcqForm') }}">Input MCQ</a></li>
            <li class="active">Generate Question</li>
        </ul>
        <div class="card-body">
            <form action="{{ route('mcqGen') }}" method="POST" style="max-width:700px;margin:auto;">
                @csrf
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <select name="class_id" id="class_id" class="custom-select" required>
                            <option value=''>Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <div style="width: 38px; height: 38px; padding: 5px; border: 1px solid rgb(221, 221, 221); border-bottom-left-radius: 5px; border-top-left-radius: 5px; display: none;" class="spinner_container">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="grp_id" id="grp_id" class="custom-select" required>
                            <option value="">Select Group</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div style="width: 38px; height: 38px; padding: 5px; border: 1px solid rgb(221, 221, 221); border-bottom-left-radius: 5px; border-top-left-radius: 5px; display: none;">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="sub_id" id="sub_id" class="custom-select @error('sub_id') is-invalid @enderror" required>
                            <option value=''>Select Subject</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection