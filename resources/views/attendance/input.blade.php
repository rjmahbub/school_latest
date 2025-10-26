@extends('layouts.iframe')
@section('title','Attendance Input')
@section('content')
<div style="background:#f4f6f9;" class="card ml-2">
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
            <li class="active">With Card</li>
            <li><a style="padding:11px 0px;" href="{{ route('AttendanceStudentForm') }}">Student</a></li>
            <li><a href="{{ route('AttendanceTeacherForm') }}">Teacher</a></li>
        </ul>
        <div class="card-body">
            <div class="row py-5">
                <div class="col-lg-5">
                    <img style="width:100%" src="/public/uploads/demo/slideshow/612b01d5c4c54.jpg" alt="">
                </div>
                <div class="col-lg-7">
                    <form id="attendanceMechine" onsubmit="return false">
                        @csrf
                        <div class="form-group clearfix">
                            <div class="icheck-danger d-inline">
                                <input type="radio" id="student" name="type" value="2" onchange="efocus()" checked>
                                <label for="student">Student</label>
                            </div>
                            <div class="icheck-primary d-inline ml-3">
                                <input type="radio" id="teacher" name="type" value="1" onchange="efocus()">
                                <label for="teacher">Teacher</label>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" onchange="efocus()" class="form-control">
                        </div>
                        <div class="form-group clearfix">
                            <input type="text" name="id" id="id" oninput="$('#attendanceMechine').submit()" class="form-control">
                        </div>
                        <div id="msg"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#id').keydown(function(event) { 
        return false;
    });
    $(document).ready(function(){
        efocus()
    })

    $('body').click(function(){
        efocus()
    })

    function efocus(){
        $('#id').val('').focus();
    }
    const success = new Audio('/public/uploads/audio/beep-01.mp3');
    const error = new Audio('/public/uploads/audio/beep-02.mp3');
    $("#attendanceMechine").on('submit',(function(e) {
        $('#msg').empty()
        e.preventDefault();
        $.ajax({
            url: "{{ route('AttendanceInput') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(result){
                efocus()
                $('#msg').html(result);
                if(result == 'Success!'){
                    success.play()
                }else{
                    error.play()
                }
            }
        })
    }))
</script>
@endsection