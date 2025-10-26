@extends('layouts.iframe')
@section('title','Class Setup')
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
        <li><a href="{{ route('SettingOthers') }}">Others</a></li>
    </ul>
    <div class="card mb-0">
        <ul id="setupMenu" class="p-0 m-0" style="background:#f4f6f9;">
            <li class="active">Class</li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingGroup') }}">Group</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingSubject') }}">Subject</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingExam') }}">Exam</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('RequestFormCGSE') }}">Request</a></li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select id="subjects" class="duallistbox" multiple="multiple">
                            @php $i = 0; @endphp
                            @foreach($classes as $class)
                            <option value="{{ $class->class_id }}" @if(array_key_exists($class->class_id,$classIds)) selected @endif>{{ $class->class_name }}</option>
                            @php $i++; @endphp
                            @endforeach
                        </select>
                    </div>
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
            $('#subjects option:selected').each(function(){
                a.push($(this).val());
            });
            $.ajax({
                url: "{{ route('InstAddClass') }}",
                type: 'POST',
                data: { _token:'{{ csrf_token() }}', ids:''+a+'' },
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
                    Swal.fire('Some Error!','','error');
                    $('.spinner_container').hide();
                }
            })
        })
    </script>
</div>
@endsection