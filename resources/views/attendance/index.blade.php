@extends('layouts.iframe')
@section('title','Attendance')
@section('content')
<style>
    a{color:initial;}
    ul#iframeMenu{display:flex;flex-wrap:wrap;background:linear-gradient(180deg, #bcd8e1, #eddcbd);border-bottom:1px solid #afafaf;}
    ul#iframeMenu>li{list-style:none;}
    ul#iframeMenu>li>a{margin-left:-1px;padding:7px 9px;padding-top:1px;}
    ul#iframeMenu>li>a.active{border-bottom: none;background:linear-gradient(180deg, #cddfe5, #f4f6f9);font-weight:bold;}
</style>

<div style="background:#f4f6f9;" class="card">
    <ul id="iframeMenu" class="p-0 m-0 ml-1 py-1">
        <li><a class="active" href="{{ route('AttendanceInputForm') }}">With Card</a></li>
        <li><a href="{{ route('AttendanceStudentForm') }}">Student</a></li>
        <li><a href="{{ route('AttendanceTeacherForm') }}">Teacher</a></li>
        <li><a href="{{ route('UpdateAttendanceForm') }}?student">Update</a></li>
        <!-- <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li> -->
    </ul>
    <div class="card-body">
        
    </div>
</div>
@endsection