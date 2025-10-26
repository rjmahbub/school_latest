@extends('layouts.iframe')
@section('title','Attendance Student')
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
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">ATTENDANCE</div>
        <li><a href="{{ route('MonthlyAttendance') }}?ym={{ date('Y-m') }}&type=1">Report</a></li>
        <li><a class="active">Input</a></li>
        <li><a href="{{ route('UpdateAttendanceForm') }}?student">Update</a></li>
    </ul>
    <div class="card">
        <ul id="setupMenu" class="p-0 m-0" style="background:#f4f6f9;">
            <li><a style="padding:11px 0px;" href="{{ route('AttendanceInputForm') }}">With Card</a></li>
            <li class="active">Student</li>
            <li><a href="{{ route('AttendanceTeacherForm') }}">Teacher</a></li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                @if($request->date && $request->class_id && $request->grp_id && $request->session)
                <div class="px-3">
                    <h5>Class: {{ $class_name }}</h5>
                    <h6>Group: {{ $group_name }}</h6>
                    <h6>Session: {{ $request->session }}</h6>
                    <h6>Date: {{ $request->date }}</h6>
                </div>
                <form action="{{ route('AttendanceStudent') }}" method="post">
                    @csrf
                    <input type="hidden" name="date" value="{{ $request->date }}">
                    <input type="hidden" name="class_id" value="{{ $request->class_id }}">
                    <input type="hidden" name="grp_id" value="{{ $request->grp_id }}">
                    <input type="hidden" name="session" value="{{ $request->session }}">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkAll" name="checkAll" value="P">
                                        <label for="checkAll"></label>
                                    </div>
                                </th>
                                <th>Roll</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" name="st{{ $student->student_id }}" id="st{{ $student->student_id }}" value="P">
                                        <label for="st{{ $student->student_id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{ $student->roll }}
                                </td>
                                <td>
                                    {{ $student->full_name }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('AttendanceStudent') }}" class="btn btn-info float-left"><i class="fa fa-arrow-left"></i> Previous</a>
                    <button type="submit" class="btn btn-success px-4 ml-5">Submit</button>
                </form>
                @else
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="student" name="student" checked>
                        <label for="student">Student Attendance Preparing Form</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="date">Attendance Type <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <select id="attendanceType" class="form-control">
                            <option value="AcademicForm" selected>Academic Day</option>
                            <option value="HolidayForm">Holiday</option>
                        </select>
                    </div>
                </div>
                <form style="display:none;" id="HolidayForm" action="{{ route('MakeAttendanceHoliday') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="date">Holiday Date <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" name="date" value="{{ old('date')?:date('Y-m-d') }}" class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success px-4 mt-3 float-right">Submit</button>
                </form>

                <form id="AcademicForm" action="">
                    <div class="form-group">
                        <label for="date">Attendance Date <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" name="date" value="{{ old('date')?:date('Y-m-d') }}" class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')
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
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
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
                        <label for="session">Session <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                            </div>
                            <input type="text" name="session" id="session" maxlength="7" list="sessions" value="{{ old('session') }}" class="form-control @error('session') is-invalid @enderror" placeholder="enter session" autocomplete="off" required>
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

                    <div>
                        <div style="width:35px;height:35px;display:none;">
                            @include('includes.spinner')
                        </div>
                        <button type="submit" id="submit" class="btn btn-info pl-5 pr-5 float-right">Next <i class="fa fa-arrow-right"></i></button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    $('#attendanceType').change(function(){
        var x = $('#attendanceType option:selected').val();
        $('form').hide();
        $('#'+x).show();
    });

    $('#checkAll').click(function(){
        if($(this).prop('checked')){
            $('input[type=checkbox]').attr('checked','true');
        }else{
            $('input[type=checkbox]').removeAttr('checked');
        }
    });
</script>
@endsection