@extends('layouts.iframe')
@section('title','Salary Payment')
@section('content')
<div style="max-width:700px;" class="card mx-auto">
    <div class="card-header">
        <h3 class="card-title">Salary Payment</h3>
    </div>
    <div class="card-body">
        <div class="form-group clearfix">
        <div class="icheck-primary d-inline">
            <input type="radio" id="student_id" name="salary_payment" checked @if(isset($_GET['student_id'])) checked @endif>
            <label for="student_id">Student ID</label>
        </div>
        <div class="icheck-primary d-inline ml-3">
            <input type="radio" name="salary_payment" id="other_info" @if(isset($_GET['other_info'])) checked @endif>
            <label for="other_info">Others Info</label>
        </div>
    </div>
    <hr>
    <form id="other_info_form" action="{{ route('PaySalaryReview') }}">

        <div class="form-group">
            <label for="session">Session</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                </div>
                <input type="text" name="session" maxlength="7" list="sessions" value="{{ old('session') }}" class="form-control @error('session') is-invalid @enderror" placeholder="enter session" autocomplete="off" required>
                <datalist id="sessions">
                    <?php
                    $y = date('Y')+2;
                    for($i=$y; $i>=$y-8; $i--){
                        $m = substr($i,2)+1;
                        echo "<option value='$i-$m'>$i-$m</option>";
                    }
                    ?>
                </datalist>
                @error('session')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="class_id">Class</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
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
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                    <div style="width: 38px; height: 38px; padding: 5px; border: 1px solid rgb(221, 221, 221); border-bottom-left-radius: 5px; border-top-left-radius: 5px; display: none;" class="spinner_container">
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
            <label for="type">Type</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                </div>
                <select name="type" id="type" onchange="rollDiv()" class="custom-select @error('type') is-invalid @enderror" required>
                    <option value="">Select option</option>
                    <option value="1">Individual Student</option>
                    <option value="2">All Student</option>
                </select>
                @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div id="rollDiv" class="form-group">
            <label for="roll">Student Roll</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                </div>
                <input type="number" name="roll" class="form-control" placeholder="roll">
                @error('roll')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary px-4">Next <i class="fa fa-arrow-right"></i></button>
        </div>
    </form>

    <form id="student_idn" action="{{ route('PaySalaryReview') }}">
        @csrf
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                </div>
                <input type="number" name="student_id" class="form-control" placeholder="student id">
                @error('student_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary px-4">Next <i class="fa fa-arrow-right"></i></button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        changeRadio();
        rollDiv();
    })
    $('input[type=radio]').click(function(){
        changeRadio()
    })
    function changeRadio(){
        $('form').hide();
        var s = $('#student_id').prop('checked');
        var t = $('#other_info').prop('checked');
        if(s == true){
            $('#student_idn').show();
        }
        if(t == true){
            $('#other_info_form').show();
        }
    }

    function rollDiv(){
        var x = $('#type option:selected').val();
        if(x == 1){
            $('#rollDiv').show();
        }else{
            $('#rollDiv').hide();
        }
    }
</script>
@endsection