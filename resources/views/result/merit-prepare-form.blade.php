@extends('layouts.iframe')
@section('title','Promotion')
@section('content')
<div style="background:#f4f6f9;" class="card">
    <div class="card-body">
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <input type="radio" id="arbr" name="promotion" checked>
                <label for="arbr">Auto Roll by Result</label>
            </div>
            <div class="icheck-primary d-inline ml-3">
                <input type="radio" name="promotion" id="pr">
                <label for="pr">Previous Roll</label>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                changeRadio();
            })
            $('input[type=radio]').click(function(){
                changeRadio()
            })
            function changeRadio(){
                $('form').hide();
                var s = $('#arbr').prop('checked');
                var t = $('#pr').prop('checked');
                if(s == true){
                    $('#form1').show();
                }
                if(t == true){
                    $('#form2').show();
                }
            }
        </script>
        <form id="form1" style="max-width:650px;" action="{{ route('MeritPositionReview') }}" method="GET">
            <input type="hidden" name="class_id" value="{{ $request->class_id }}" required>
            <input type="hidden" name="class_name" value="{{ $request->class_name }}" required>
            <input type="hidden" name="group_name" value="{{ $request->group_name }}" required>
            <input type="hidden" name="grp_id" value="{{ $request->grp_id }}">
            <input type="hidden" name="session" value="{{ $request->session }}" required>
            <input type="hidden" name="type" value="auto">
            <div class="row bg-white">
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding">Passing Year</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="year" class="input-shadow edutab pl-3 @error('father') is-invalid @enderror" placeholder="yyyy" required>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding">Exam</div>
                    <div class="col-md-9 col-7 input_field">
                        <select name="exam_id" id="exam_id" class="tbl_ip_menu form-select form-control" required>
                            <option value="">Select exam</option>
                            @foreach($exams as $exam)
                            <option value="{{ $exam->exam_id }}">{{ $exam->exam_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="MonthRow" class="col-12 p-0">
                    <div class="fild_box d-flex mt-2">
                        <div class="col-md-3 col-5 label_div ng-binding">Month</div>
                        <div class="col-md-9 col-7 input_field">
                            <select name="month" id="month" class="tbl_ip_menu form-select form-control">
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
                        </div>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding">Class</div>
                    <div class="col-md-9 col-7 input_field">
                        <select name="class_id" id="class_id" class="tbl_ip_menu form-select form-control" required>
                            <option value=''>Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding">Group</div>
                    <div class="col-md-9 col-7 input_field">
                        <select name="grp_id" id="grp_id" class="tbl_ip_menu form-select form-control">
                            <option value="">Select Group</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="width:35px;height:35px;display:none;">
                    @include('includes.spinner')
                </div>
                <button type="submit" id="submit" class="btn btn-info px-3">Next <i class="fa fa-arrow-right"></i></button>
            </div>
        </form>
        <form id="form2" action="{{ route('MeritPositionReview') }}" style="max-width: 650px;">
            <input type="hidden" name="class_id" value="{{ $request->class_id }}" required>
            <input type="hidden" name="class_name" value="{{ $request->class_name }}" required>
            <input type="hidden" name="group_name" value="{{ $request->group_name }}" required>
            <input type="hidden" name="grp_id" value="{{ $request->grp_id }}">
            <input type="hidden" name="session" value="{{ $request->session }}" required>
            <input type="hidden" name="type" value="manual">
            <div class="modal-footer">
                <div style="width:35px;height:35px;display:none;">
                    @include('includes.spinner')
                </div>
                <button type="submit" id="submit" class="btn btn-info px-3">Next <i class="fa fa-arrow-right"></i></button>
            </div>
        </form>
    </div>
</div>
@endsection