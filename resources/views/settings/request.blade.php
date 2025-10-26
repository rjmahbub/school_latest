@extends('layouts.iframe')
@section('title','Request Class, Subject or Group')
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
            <li><a style="padding:11px 0px;" href="{{ route('SettingExam') }}">Group</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingSubject') }}">Subject</a></li>
            <li><a style="padding:11px 0px;" href="{{ route('SettingExam') }}">Exam</a></li>
            <li class="active">Request</li>
        </ul>
        <div class="card-body" style="max-width:700px;">
            <div class="row">
                <div class="col-12 pt-3">
                    <form action="{{ route('RequestFormCGSE') }}" method="POST">
                        <div class="form-group">
                            <label for="class_id">Choose One</label>
                            <select name="cgse" id="cgse" class="form-control">
                                <option value="">Select ...</option>
                                <option value="0">Class</option>
                                <option value="1">Group</option>
                                <option value="2">Subject</option>
                                <option value="3">Exam</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="class_id">Selected Name</label>
                            <input type="text" name="cgseName" id="cgseName" class="form-control" placeholder="enter name">
                        </div>

                        <div class="form-group">
                            <label for="class_id">Remarks</label>
                            <input type="text" name="remarks" class="form-control" placeholder="ex: class, group">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <div style="width:30px;height:30px;display:none;" class="spinner_container">
                            @include('includes.spinner')
                        </div>
                        <button id="submit" class="btn btn-success px-5">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#submit').click(function(){
            $('.spinner_container').show();
            var name = $('#cgseName').val();
            var cgse = $('#cgse option:selected').val();
            if(name == '' || cgse == ''){
                alert('Please fill require form!');
                $('.spinner_container').hide();
                exit();
            }
            $.ajax({
                url: "{{ route('RequestCGSE') }}",
                type: 'POST',
                data: { _token:'{{ csrf_token() }}', name:''+name+'', cgse:''+cgse+''},
                success: function(result){
                    if(result == true){
                        Swal.fire('Saved!','','success');
                        $('.spinner_container').hide();
                        $('#cgseName,#cgse').val('');
                    }else{
                        Swal.fire('Some Error!','','error');
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