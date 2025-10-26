@extends('layouts.iframe')
@section('title','Publish Result')
@section('content')
<div style="max-width:600px; margin:auto;">
    <div class="text-center">
        <h4 class="mb-0">{{ $exam_name }} Exam @php echo ucfirst($request->month); @endphp {{ $request->year }}</h4>
        <h5 class="mb-0">Class {{ $class_name }}</h5>
        @if($group_name)
            <h6 class="mb-0">{{ $group_name }}</h6>
        @endif
        <h6>Subject : {{ $sub_name }}</h6>
    </div>
    <div style="margin:5px auto;position:absolute;top:75px;"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ResultPublishForm"><i class="fa fa-edit"></i> Publish Form</button></div>
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Marks input | Result Publish</h3>
		</div>
		<div class="card-body">
            <ul>
                <li>leave blank marks field if student absence.</li>
            </ul>
            <form id="rp_final" action="{{ route('rp_final') }}" method="POST">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Roll</th>
                            <th class="text-center">Marks</th>
                        </tr>
                    </thead>
                        <input type="hidden" name="year" value="{{ $request->year }}" required>
                        <input type="hidden" name="exam_id" value="{{ $request->exam_id }}" required>
                        <input type="hidden" name="month" value="{{ $request->month }}">
                        <input type="hidden" name="class_id" value="{{ $request->class_id }}" required>
                        <input type="hidden" name="grp_id" value="{{ $request->grp_id }}" required>
                        <input type="hidden" name="sub_id" value="{{ $request->sub_id }}" required>
                        <input type="hidden" name="sub_name" value="{{ $sub_name }}" required>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $i }} <input type="hidden" name="student_id[]" value="{{ $student->student_id }}" required></td>
                            <td>{{ $student->full_name }}</td>
                            <td class="text-center"><input style="width:70px;" class="mx-1" type="number" name="roll[]" id="roll" value="{{ $student->roll }}" required></td>
                            <td class="text-center"><input style="width:70px;" class="next mx-1" type="number" name="marks[]" id="marks"></td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="modal-footer">
                    <div id="spinner" style="width:35px;height:35px;display:none;" class="spinner_container">
                        @include('includes.spinner')
                    </div>
                    <button type="submit" class="btn btn-info pl-5 pr-5">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ResultPublishForm" tabindex="-1" role="dialog" aria-labelledby="ResultPublishLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ResultPublishLabel">Result Publish Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card card-info">
            <div class="card-body">
            <form id="ResultPublish" action="" method="GET">
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
                            ?>
                            @for($i=$y; $i>=$y-4; $i--)
                                <option value='{{$i}}' @if($i == $request->year) selected @endif>{{$i}}</option>
                            @endfor
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
                            <option value="{{ $exam->exam_id }}" @if($exam->exam_id == $request->exam_id) selected @endif>{{ $exam->exam_name }}</option>
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
                    <label for="grp_id">Group <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div class="spnr" class="spinner_container">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="grp_id" id="grp_id" class="custom-select @error('grp_id') is-invalid @enderror" required>
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
                            <div class="spinner_container spnr">
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
            </div>
            <div class="modal-footer">
                <div id="spinner2" style="width:35px;height:35px;display:none;" class="spinner_container">
                    @include('includes.spinner')
                </div>
                <button type="submit" id="submit" class="btn btn-info px-4">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </form>
            <script>
                $( "#rp_final" ).submit(function( event ) {
                    $('#spinner').css('opacity','1');
                });

                $( "#ResultPublish" ).submit(function( event ) {
                    $('#spinner2').css('opacity','1');
                });
            </script>
            
        </div>
      </div>
    </div>
  </div>
</div>
@endsection