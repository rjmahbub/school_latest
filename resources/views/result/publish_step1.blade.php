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
        <li><a class="active">Publish Result</a></li>
        <li><a href="{{ route('ResultShowForm') }}">Result Show</a></li>
    </ul>
    <form id="ResultPublish" action="{{ route('rp_step2') }}" method="GET" style="background:#f4f6f9;max-width:700px;padding:20px;">
        @csrf
        <div class="form-group">
            <label for="year">Passing Year <span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="number" name="year" id="year" list="years" class="form-control @error('year') is-invalid @enderror" placeholder="passing year" autocomplete="off" required>
                <datalist id="years">
                    <?php
                        $y = date('Y')+1;
                        for($i=$y; $i>=$y-4; $i--){
                            echo "<option value='$i'>$i</option>";
                        }
                    ?>
                </datalist>
                @error('year')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="exam_id">Exam <span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <select name="exam_id" id="exam_id" class="custom-select @error('exam_id') is-invalid @enderror" required>
                    <option value="">Select exam</option>
                    @foreach($exams as $exam)
                    <option value="{{ $exam->exam_id }}">{{ $exam->exam_name }}</option>
                    @endforeach
                </select>
                @error('exam_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div id="MonthRow" class="form-group">
            <label for="month">Month <span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <select name="month" id="month" class="custom-select @error('month') is-invalid @enderror">
                    <option value="">Select Month</option>
                    <option value="jan">January</option>
                    <option value="feb">February</option>
                    <option value="mar">March</option>
                    <option value="apr">April</option>
                    <option value="may">May</option>
                    <option value="jun">June</option>
                    <option value="jul">July</option>
                    <option value="aug">August</option>
                    <option value="sep">September</option>
                    <option value="oct">October</option>
                    <option value="nov">November</option>
                    <option value="dec">December</option>
                </select>
                @error('month')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="class_id">Class <span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <select name="class_id" id="class_id" class="custom-select @error('class_id') is-invalid @enderror" required>
                    <option value=''>Select Class</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                    @endforeach
                </select>
                @error('class_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="grp_id">Group</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <div class="spnr">
                        @include('includes.spinner')
                    </div>
                </div>
                <select name="grp_id" id="grp_id" class="custom-select @error('grp_id') is-invalid @enderror">
                    <option value="">Select Group</option>
                </select>
                @error('grp_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="sub_id">Subject <span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <div class="spnr">
                        @include('includes.spinner')
                    </div>
                </div>
                <select name="sub_id" id="sub_id" class="custom-select @error('sub_id') is-invalid @enderror" required>
                    <option value=''>Select Subject</option>
                </select>
                @error('sub_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <div style="width:35px;height:35px;display:none;">
                @include('includes.spinner')
            </div>
            <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Next</button>
        </div>
    </form>
</div>
@endsection