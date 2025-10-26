@extends('layouts.iframe')
@section('content')
<div style="max-width:500px; margin:auto;">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Student Admission Form</h3>
		</div>
		<div class="card-body">
        <form id="SaveStudent" action="{{ route('SaveStudent') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <label for="session">Session <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <input type="text" name="session" id="session" list="sessions" value="{{ old('session') }}" class="form-control @error('session') is-invalid @enderror" placeholder="enter session" required>
                        <datalist id="sessions">
                            <?php
                                $y = date('Y');
                                for($i=$y; $i>=$y-4; $i--){
                                    $m = $i+1;
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

                <div class="form-group">
                    <label for="class_id">Class <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
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
                    <label for="group">Group <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <div style="width: 40px;height: 40px;padding: 5px;opacity:1;background: #e9ecef;display:none;" class="spinner_container">
                                @include('includes.spinner')
                            </div>
                        </div>
                        <select name="grp_id" id="grp_id" class="custom-select @error('class_id') is-invalid @enderror" required>
                            <option value='0'>Select Group</option>
                        </select>
                        @error('group')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="roll">Roll Number <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="number" name="roll" id="roll" value="{{ old('roll') }}" class="form-control @error('roll') is-invalid @enderror" placeholder="roll number" required>
                        @error('roll')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="full_name">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" placeholder="full name" required>
                        @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender">Gender <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <select name="gender" id="gender" class="custom-select @error('gender') is-invalid @enderror" required>
                            <option value="">Select...</option>
                            <option value="male" @if(old('gender') == 'male') selected @endif>Male</option>
                            <option value="female" @if(old('gender') == 'female') selected @endif>Female</option>
                            <option value="others" @if(old('gender') == 'others') selected @endif>Others</option>
                        </select>
                        @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob">Date of birth <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="date" name="dob" id="dob" value="{{ old('dob') }}" class="form-control @error('dob') is-invalid @enderror" required>
                        @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="father">Father's Name <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="father" id="father" value="{{ old('father') }}" class="form-control @error('father') is-invalid @enderror" placeholder="father's name" required>
                        @error('father')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="mother">Mother's Name <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="mother" id="mother" value="{{ old('mother') }}" class="form-control @error('mother') is-invalid @enderror" placeholder="mother's name" required>
                        @error('mother')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="present_addr">Present Address</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <input type="text" name="present_addr" id="present_addr" value="{{ old('present_addr') }}" class="form-control @error('present_addr') is-invalid @enderror" placeholder="present address" required>
                    @error('present_addr')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="permanent_addr">Permanent Address</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <input type="text" name="permanent_addr" id="permanent_addr" value="{{ old('permanent_addr') }}" class="form-control @error('permanent_addr') is-invalid @enderror" placeholder="permanent address">
                        @error('permanent_addr')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="phone number"  maxlength="11" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email address">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="photo">Add Photo</label>
                    <div class="input-group mb-3">
                        <input class="w-100" type="file" name="photo" id="photo" />
                        <div class="w-100"><img style="width:150px; height:170px;" id="photo_preview" src="/public/assets/img/app/add-user.png" /></div>
                        <span style="position: absolute;top: 50%;left: 33px;" class="text-danger" id="photo_msg"></span>
                        @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex">
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
                <div style="width:35px;height:35px;" class="spinner_container ml-3">
                    @include('includes.spinner')
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#class_id").change(function(){
            $('#grp_id').prev().children('span').hide();
            $('#grp_id').prev().children('div').show();
            $("#grp_id").html('');
            var class_id = $("#class_id option:selected").val();
            group_load(class_id);
        });

        $( "#SaveStudent" ).submit(function( event ) {
			$('.spinner_container').css('opacity','1');
		});
    });

    function group_load(class_id){
        $.ajax({
            url: "/group_load?class_id="+class_id,
            data: {_token:'{{ csrf_token() }}'},
            success: function(groups){
                if(groups!=''){
                    var null_val = "<option value=''>Select Group</option>";
                    var group_options = null_val+groups;
                    $("#grp_id").html(group_options).parent().parent().show();
                    $('#grp_id').prop('required',true);
                    $('#grp_id').prev().children('span').show();
                    $('#grp_id').prev().children('div').hide();
                }else{
                    var null_val = "<option value=''>Select Group</option>";
                    var grp_id = null;
                    $("#grp_id").html(null_val).parent().parent().hide();
                    $('#grp_id').prop('required',false);
                    $('#grp_id').prev().children('span').show();
                    $('#grp_id').prev().children('div').hide();
                    subject_load(class_id,grp_id);
                }
            }
        });
    }
</script>
@endsection
