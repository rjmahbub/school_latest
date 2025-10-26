@extends('layouts.iframe')
@section('title','Salary Payment')
@section('content')
@if($request->student_id || $request->type == 1)
<div style="max-width:600px;" class="bootstrap-table table-responsive bootstrap4 mx-auto">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Student Name:</th>
                <td colspan="3">{{ $student->full_name }}</td>
            </tr>
            <tr>
                <th>Father Name:</th>
                <td colspan="3">{{ $student->father }}</td>
            </tr>
            <tr>
                <th>Mother Name:</th>
                <td colspan="3">{{ $student->mother }}</td>
            </tr>
            <tr>
                <th>Class:</th>
                <td>{{ $class_name }}</td>
                @if($group_name)
                <th>Group:</th>
                <td>{{ $group_name }}</td>
                @endif
            </tr>
            <tr>
                <th>Roll:</th>
                <td>{{ $student->roll }}</td>
                <th>Session:</th>
                <td>{{ $student->session }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <form action="{{ route('PaySalary') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->student_id }}">
        <div class="form-group">
            <label for="month">Month</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="month" name="month" class="form-control" required>
                @error('month')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="amount">Salary Amount</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                </div>
                <input type="number" name="amount" class="form-control" placeholder="salary">
                @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-primary px-3">Submit</button>
        </div>
    </form>
</div>
@else
<div style="max-width:600px;" class="bootstrap-table bootstrap4 mx-auto">
    <form action="{{ route('PaySalary') }}" method="POST">
    @csrf
    <div>
        <h5>Class: Session: {{ $request->session }}</h5>
        <div class="form-group">
            <label for="month">Month</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="month" name="month" class="form-control" required>
                @error('month')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">Student Name</th>
                <th class="text-center">Roll</th>
                <th class="text-center">Salary <i style="cursor:pointer;" id="paste" class="fa fa-paste float-right"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->full_name }} <input type="hidden" name="studentIds[]" value="{{ $student->student_id }}"></td>
                <td class="text-center">{{ $student->roll }}</td>
                <td class="text-center"><input style="width:100px;" type="number" name="amount[]" min="1"></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><button class="btn btn-primary px-3">Submit</button></td>
            </tr>
        </tbody>
    </table>
    </form>
</div>
<script>
    $('#paste').click(function(){
        var x = $('input[type=number]');
        x.each(function(){
            x.val(x.val())
        })
    })
</script>
@endif
@endsection