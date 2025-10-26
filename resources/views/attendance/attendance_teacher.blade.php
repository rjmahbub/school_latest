@extends('layouts.iframe')
@section('title','Attendance Teacher')
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
            <li><a style="padding:11px 0px;" href="{{ route('AttendanceStudentForm') }}">Student</a></li>
            <li class="active">Teacher</li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    @if( isset($_GET['date']) )
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="teacher" name="teacher" checked>
                            <label for="teacher">Teacher Attendance Prepare Form</label>
                        </div>
                    </div>
                    <h6>Date {{ $_GET['date'] }}</h6>
                    <form action="{{ route('AttendanceTeacher') }}" method="post">
                        @csrf
                        <input type="hidden" name="date" value="{{ $_GET['date'] }}">
                        <table class="table table-responsive ml-4">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="icheck-success d-inline">
                                            <input type="checkbox" id="checkAll" name="checkAll" value="P">
                                            <label for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="icheck-success d-inline">
                                            <input type="checkbox" name="tcr{{ $teacher->id }}" id="tcr{{ $teacher->id }}" value="P">
                                            <label for="tcr{{ $teacher->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $teacher->full_name }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('AttendanceTeacher') }}" class="btn btn-info float-left"><i class="fa fa-arrow-left"></i> Previous</a>
                        <button type="submit" class="btn btn-success px-4 ml-5">Submit</button>
                    </form>
                    @else
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="teacher" name="teacher" checked>
                            <label for="teacher">Teacher Attendance Prepare Form</label>
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

                    <form style="display:none;" id="HolidayForm" action="{{ route('MakeTeacherHoliday') }}" method="post">
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
</div>
@endsection