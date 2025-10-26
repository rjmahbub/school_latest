<link rel="stylesheet" href="{{ base_path().'\public\public\assets\plugins\bootstrap\css\bootstrap.min.css' }}">
<style>
    @page { margin-bottom: 0px; }
    body { margin: 0px; }
</style>
<?php $n = 1; ?>
@foreach($students as $student)
<?php
    if($student['photo'] == null){
        $path = base_path().'/public/public/uploads/common/photo_blank.png';
    }else{
        $path = base_path()."/public/public/uploads/$prefix/students/".$student['photo'];
    }
?>
<div class="text-center">
    <h3>{{ $inst->inst_name }}</h3>
    <h4>{{ $request->exam }} - {{ ucfirst($request->month) }} {{ $request->year }}</h4>
    <button style="width:150px;margin:auto;" type="button" class="btn btn-outline-primary">Admit Card</button>
</div>
<div class="text-right">
    <img style="width:1.2in;height:1.45in;margin-top:-40px;" src="{{ $path }}" alt="">
</div>
<table class="table">
    <tbody>
        <tr>
            <td style="width:130px;">Name of Student</td>
            <td style="width:5px;">:</td>
            <td colspan="7">{{ $student['full_name'] }}</td>
        </tr>
        <tr>
            <td>Father's Name</td>
            <td>:</td>
            <td colspan="7">{{ $student['father'] }}</td>
        </tr>
        <tr>
            <td>Class</td>
            <td>:</td>
            <td>{{ $student['class_name'] }}</td>
            <td style="width:50px;">Session</td>
            <td style="width:5px;">:</td>
            <td>{{ $student['session'] }}</td>
            <td style="width:25px;">Roll</td>
            <td style="width:5px;">:</td>
            <td>{{ $student['roll'] }}</td>
        </tr>
        
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
<table class="w-100 text-center">
    <tbody>
        <tr>
            <td>Student Signature</td>
            <td>
                <img style="width:100px;height:30px;" src="{{ base_path() }}\public\public\uploads\{{ $prefix }}\signature\{{ $sig }}" alt="">    
                <p class="mb-0">Principal Signature</p>
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<br>
    @if(is_int($n/2))
    <div style="page-break-before:always;"> </div>
    @endif
    <?php $n++; ?>
@endforeach