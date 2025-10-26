@extends('layouts.iframe')
@section('title','Subject Setup')
@section('content')
<div class="card ml-2">
    <ul id="iframeMenu" class="p-0 m-0">
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
            <ul id="iframeNavigation" class="mb-0">
                <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
            </ul>
        </div>
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">SETUP</div>
        <li><a class="active">Academy</a></li>
        <li><a href="#">Others</a></li>
    </ul>
    <div class="card mb-0">
        <ul id="setupMenu" class="p-0 m-0" style="background:#f4f6f9;">
            <li><a style="padding:11px 0px;" href="{{ route('SettingClass') }}">Class</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingGroup') }}">Group</a></li>
            <li class="active">Subject</li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingExam') }}">Exam</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('RequestFormCGSE') }}">Request</a></li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="class_id">Select Class</label>
                            <select name="class_id" id="class" onchange="window.location.href='?class_id='+this.value" class="form-control">
                                <option value="">Choose Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->class_id }}" @if($request->class_id == $class->class_id) selected @endif>{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($groups)
                        <div class="form-group">
                            <label for="class_id">Select Group</label>
                            <select name="grp_id" id="grp" onchange="window.location.href='?class_id='+$('#class').val()+'&grp_id='+this.value" class="form-control">
                                <option value="">Choose Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->grp_id }}" @if($request->grp_id == $group->grp_id) selected @endif>{{ $group->grp_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    @if($classes && isset($_GET['class_id']))
                    <div class="form-group">
                        <select id="selectGroups" class="duallistbox" multiple="multiple">
                            @php $i = 0; @endphp
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->sub_id }}" @if(array_key_exists($subject->sub_id,$subs)) selected @endif>{{ $subject->sub_name }}</option>
                            @php $i++; @endphp
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div style="width:30px;height:30px;display:none;" class="spinner_container">
                @include('includes.spinner')
            </div>
            <button id="submit" class="btn btn-success px-5">Submit</button>
        </div>
    </div>
    <script>
        $('#submit').click(function(){
            $('.spinner_container').show();
            var a = [];
            $('#selectGroups option:selected').each(function(){
                a.push($(this).val());
            });
            $.ajax({
                url: "{{ route('InstAddSubject') }}",
                type: 'POST',
                data: { _token:'{{ csrf_token() }}', class_id:'{{ $request->class_id }}', grp_id:'{{ $request->grp_id }}', ids:''+a+'' },
                success: function(result){
                    if(result == true){
                        Swal.fire('Saved!','','success');
                        $('.spinner_container').hide();
                    }else{
                        Swal.fire('Nothing Update!','','warning');
                        $('.spinner_container').hide();
                    }
                },
                error: function(e){
                    Swal.fire('Error!','','error');
                    $('.spinner_container').hide();
                }
            })
        })
    </script>
</div>
@endsection