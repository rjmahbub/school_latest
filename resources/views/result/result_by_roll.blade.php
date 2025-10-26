@extends('layouts.iframe')
@section('title','Result by roll')
@section('content')
<style>
    .table td, .table th{border: 1px solid #dee2e6;}
    .card-body>.table>thead>tr>td, .card-body>.table>thead>tr>th{border-top-width: 1px;}
</style>
<div style="max-width:600px; margin:auto;">
	<div class="card card-secondary">
        <div class="text-center pt-2">
            <h4 class="mb-0">{{ $exam_name }} Examination {{ $year }}</h4>
            <h5 class="mb-0">@if($month != '') {{ $month }} {{ $year }} @endif</h5>
            <h5 class="mb-0">Class {{ $class_name }}</h5>
            @if($group_name)
                <h6 class="mb-0">{{ $group_name }}</h6>
            @endif
        </div>
		<div class="card-header mt-2">
			<h3 class="card-title">Student's Information</h3>
		</div>
		<div class="card-body">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row">Roll No</th>
                        <td colspan="3">{{ $student->roll }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name of Student</th>
                        <td colspan="3">{{ $student->full_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Father's Name</th>
                        <td colspan="3">{{ $student->father }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Mothers's Name</th>
                        <td colspan="3">{{ $student->mother }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Date of Birth</th>
                        <td>12-2-2020</td>
                        <th scope="row">Gender</th>
                        <td>{{ ucfirst($student->gender) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Group</th>
                        <td>{{ $group_name }}</td>
                        <th scope="row">Session</th>
                        <td>{{ $student->session }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-header">
			<h3 class="card-title">Subject-wise Result</h3>
		</div>
        <div class="card-body">
            <table class="table table-striped">
                <tbody>
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Grade/Marks</th>
                        </tr>
                    </thead>
                    @foreach($results as $result)
                    <tr>
                        <th scope="row">{{ $result['sub_name'] }}</th>
                        <td colspan="3">{{ $result['marks'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>