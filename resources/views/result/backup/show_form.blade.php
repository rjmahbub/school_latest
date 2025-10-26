@extends('layouts.iframe')
@section('content')
<div style="max-width:500px; margin:auto;">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Show Result</h3>
		</div>
		<div class="card-body">
        <form id="ResultPublish" action="{{ route('ResultShow') }}" target="_blank" method="POST">
            @csrf
                <div class="form-group">
                    <label for="year">Passing Year <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <select name="year" id="year" class="custom-select @error('year') is-invalid @enderror" required>
                            <option value=''>Select Year</option>
                            <?php
                                $y = date('Y');
                                for($i=$y; $i>=$y-1; $i--){
                                    echo "<option value='$i'>$i</option>";
                                }
                            ?>
                        </select>
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
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
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
                    <label for="grp_id">Group <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div style="width: 38px; height: 38px; padding: 5px; border: 1px solid rgb(221, 221, 221); border-bottom-left-radius: 5px; border-top-left-radius: 5px; display: none;">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="grp_id" id="grp_id" class="custom-select @error('grp_id') is-invalid @enderror" required>
                            <option value='0'>Select Group</option>
                        </select>
                        @error('grp_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="restype">Result Type <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div style="width:38px;height:38px;padding:5px;display:none;">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="restype" id="restype" onchange="if(this.value == 1){$('#rollRow').show()}else{$('#rollRow').hide()}" class="custom-select @error('restype') is-invalid @enderror" required>
                            <option value=''>Select Result Type</option>
                            <option value='1'>Individual by Roll</option>
                            <option value='2'>Result Sheet</option>
                        </select>
                        @error('restype')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div id="rollRow" class="form-group">
                    <label for="roll">Roll Number</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="roll" id="roll" value="{{ old('roll') }}" class="form-control @error('roll') is-invalid @enderror" placeholder="roll number">
                        @error('roll')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="width:35px;height:35px;display:none;">
                    @include('includes.spinner')
                </div>
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        var restype = $('#restype option:selected').val();
        if(restype == 1){
            $('#rollRow').show();
        }else{
            $('#rollRow').hide();
        }
    })
</script>
@endsection