@extends('layouts.iframe')
@section('title','Monthly Attendance')
@section('content')
<?php
    $ym = $request->ym;
    $month = date('m', strtotime($ym));
    $monthStr = date('M', strtotime($ym));
    $year = date('Y', strtotime($ym));
    $days = date('t', mktime(0, 0, 0, $month, 1, $year));
    $type = $request->type;
    if($type == 1){
        $jsonUrl = "?ym=$ym&type=$type";
        $typeTx = 'Teacher';
    }else{
        $class_id = $request->class_id;
        $grp_id = $request->grp_id;
        $session = $request->session;
        $typeTx = 'Students';
        $jsonUrl = "?ym=$ym&type=$type&class_id=$class_id&grp_id=$grp_id&session=$session";
    }
?>
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
        <li><a class="active">Report</a></li>
        <li><a href="{{ route('AttendanceInputForm') }}">Input</a></li>
        <li><a href="{{ route('UpdateAttendanceForm') }}?student">Update</a></li>
    </ul>
    <div class="card">
        <ul id="setupMenu" class="p-0 m-0" style="background:#f4f6f9;">
            <li class="active">Full Month</li>
            <li><a href="{{ route('CalendarViewAttendance') }}">Calendar View</a></li>
        </ul>
        <div class="card-body">
            <div class="text-center">
                <h4>{{ $typeTx.' Attendance' }}</h4>
                @if($type == 2)
                <p class="mb-0">{{ 'Class: '.$class_name }} | {{ 'Group: '.$group_name }}</p>
                @endif
                <h6>{{ date('F Y',strtotime($ym)) }}</h6>
            </div>
            <div id="toolbar">
                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalAttendance"><i class="fa fa-filter"></i> Filter</button>
            </div>
            <table
                id="AttendanceTable"
                data-toolbar="#toolbar"
                data-search="true"
                data-show-refresh="true"
                data-show-fullscreen="true"
                data-show-columns="true"
                data-show-columns-toggle-all="true"
                data-minimum-count-columns="2"
                data-show-export="true"
                data-click-to-select="true"
                data-export-types="['doc','excel','pdf']"
                data-pagination="true"
                data-page-list="[10, 25, 50, 100, 150, all]"
                data-side-pagination="server"
                data-show-print="true"
                data-url="{{ route('MonthlyAttendanceJson') }}{{ $jsonUrl }}"
                data-response-handler="responseHandler">
            </table>
            <script>
                var $AttendanceTable = $('#AttendanceTable')

                function responseHandler(res) {
                    $.each(res.rows, function (i, row) {
                    row.state = $.inArray(row.id, selections) !== -1
                    })
                    return res
                }

                function totalFormatter(data) {
                    var total = 0;
                    if (data.length > 0) {
                    var field = this.field;
                    total = data.reduce(function(sum, row) {
                        return sum + (+row[field]);
                    }, 0);
                    var num = '= ' + total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    return num;
                    }
                    return '';
                }

                function operateFormatter(value, row, index) {
                    return [
                    '<a style="margin: 0 3px 0 3px; font-size:35px;" class="Calendar" href="{{ route("CalendarViewAttendance") }}?type='+row.type+'&id='+row.id+'" title="View in calendar">','<i class="fa fa-calendar-alt"></i>','</a> '
                    ].join('')
                }
            
            window.operateEvents = {
                'click .Calendar': function (e, value, row, index) {
                    
                }
            }
                function initTable() {
                    $AttendanceTable.bootstrapTable('destroy').bootstrapTable({
                        columns:[
                            {
                            field: 'operate',
                            title: 'Calendar View',
                            align: 'center',
                            clickToSelect: false,
                            events: window.operateEvents,
                            formatter: operateFormatter
                            },
                            {
                            field: 'full_name',
                            @if($type == 1)
                            title: 'Teacher Name'
                            @else
                            title: 'Student Name'
                            @endif
                            }
                            @for($i=1;$i<=$days;$i++)
                            ,{
                            field: 'd{{ $i }}',
                            title: '{{ $i }}',
                            align: 'center'
                            }
                            @endfor
                        ]
                    })
                }
                $(function() {
                    initTable()
                })
            </script>
            <div class="modal fade" id="Modal" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 450px;background:#fff;" class="modal-dialog">
                    <div class="modal-header">
                        <h4 id="StudentName" class="modal-title text-center">Attendance</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ModalAttendance" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 470px" class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 id="StudentName" class="modal-title">Student Name</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="date">Attendance Clint <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <select id="attendanceType" class="form-control">
                                    <option value="student" @if($type == 2) selected @endif>Student</option>
                                    <option value="teacher" @if($type == 1) selected @endif>Teacher</option>
                                </select>
                            </div>
                        </div>
                        <form @if($type == 2) style="display:none;" @endif id="teacher" action="">
                            <div class="form-group">
                                <label for="date">Attendance Month <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="month" name="ym" value="{{ $ym }}" class="form-control @error('date') is-invalid @enderror" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>
                            <input type="hidden" name="type" value="1">
                            <button type="submit" class="btn btn-success px-4 mt-3 float-right">Submit</button>
                        </form>

                        <form id="student" @if($type == 1) style="display:none;" @endif action="">
                            <div class="form-group">
                                <label for="date">Attendance Month <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="month" name="ym" value="{{ $ym }}" class="form-control @error('date') is-invalid @enderror" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>

                            <input type="hidden" name="type" value="2">

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
                                        <div class="spnr">
                                            @include('includes.spinner')
                                        </div>
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
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info px-5">Submit</button>
                            </div>
                        </form>


                    </div>
                </div>
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
</script>
@endsection