@extends('layouts.iframe')
@section('title','MCQ Generate')
@section('content')
<style>
    a{color:initial;}
    ul#setupMenu{display:flex;}
    ul#setupMenu>li{list-style:none;cursor: pointer;padding:9px 10px;border-bottom:1px solid #cacedc}
    ul#setupMenu>li.active{border: 1px solid #e0dee6;border-bottom: none;}
</style>

<div class="col-lg-12">
    <div style="background:#f4f6f9;" class="card">
        <ul id="setupMenu" class="p-0 m-0">
            <li class="active">Input MCQ</li>
            <li><a style="padding:11px 0px;" href="{{ route('mcqGenForm') }}">Generate Question</a></li>
        </ul>
        <div class="card-body">
            <form id="mcqForm" method="POST" onsubmit="return false" style="max-width:700px;margin:auto;">
                @csrf
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <select name="class_id" id="class_id" class="custom-select" required>
                            <option value=''>Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <div style="width: 38px; height: 38px; padding: 5px; border: 1px solid rgb(221, 221, 221); border-bottom-left-radius: 5px; border-top-left-radius: 5px; display: none;" class="spinner_container">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="grp_id" id="grp_id" class="custom-select" required>
                            <option value="">Select Group</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div class="spnr">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="sub_id" id="sub_id" class="custom-select @error('sub_id') is-invalid @enderror" required>
                            <option value=''>Select Subject</option>
                        </select>
                        @error('sub_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <input type="number" name="chapter" class="form-control" placeholder="chapter no">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="qname" id="qname"  class="form-control" placeholder="question name" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <input style="width: 33px;height: 20px;margin-top: 10px;" type="radio" name="ans" value="1" required>
                                </div>
                                <input type="text" name="opt_one" id="opt_one" class="form-control" placeholder="option 1" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <input style="width: 33px;height: 20px;margin-top: 10px;" type="radio" name="ans" value="2" required>
                                </div>
                                <input type="text" name="opt_two" id="opt_two" class="form-control" placeholder="option 2" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <input style="width: 33px;height: 20px;margin-top: 10px;" type="radio" name="ans" value="3" required>
                                </div>
                                <input type="text" name="opt_three" id="opt_three" class="form-control" placeholder="option 3">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <input style="width: 33px;height: 20px;margin-top: 10px;" type="radio" name="ans" value="4" required>
                                </div>
                                <input type="text" name="opt_four" id="opt_four" class="form-control" placeholder="option 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="ref" id="ref" class="form-control" placeholder="ref: page no (optinal)">
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="spinner" style="width:35px;height:35px;display:none;">
                        @include('includes.spinner')
                    </div>
                    <div id="message" style="display:none;"></div>
                    <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
                </div>
            </form>
            <script>
                $("#mcqForm").on('submit',(function(e) {
                e.preventDefault();
                $("#message").empty();
                $('#spinner').show();
                $.ajax({
                    url: "{{ route('AddMcq') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(result){
                        $("#message").show().html(result);
                        $('#spinner').hide();
                        $('#qname,#opt_one,#opt_two,#opt_three,#opt_four,#ref').val('');
                    }
                })
            }))
            </script>
        </div>
    </div>
</div>
@endsection