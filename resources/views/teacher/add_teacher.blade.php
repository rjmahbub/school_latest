@extends('layouts.iframe')
@section('title','New Teacher')
@section('content')
<form style="width:700px;margin:auto;" action="{{ route('SaveTeacher') }}" method="POST">
    <div class="card">
        <div class="card-body">
            @csrf
            <input type="hidden" name="photo" id="photo" value="">
            <div class="row">
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Teacher Name</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="full_name" class="input-shadow edutab" placeholder="full name" required>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Gender</div>
                    <div class="col-md-9 col-7 input_field">
                        <select name="gender" class="tbl_ip_menu form-select form-control" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Date of Birth</div>
                    <div class="col-md-9 col-7 input_field">
                    <input type="date" name="dob" value="{{ old('dob') }}" class="input-shadow edutab @error('dob') is-invalid @enderror" required>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Father's Name</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="father" value="{{ old('father') }}" class="input-shadow edutab @error('father') is-invalid @enderror" placeholder="father's name" required>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Mother's Name</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="mother" value="{{ old('mother') }}" class="input-shadow edutab @error('mother') is-invalid @enderror" placeholder="mother's name" required>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Present Address</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="present_addr" value="{{ old('present_addr') }}" class="input-shadow edutab @error('present_addr') is-invalid @enderror" placeholder="present address">
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Permanent Address</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="permanent_addr" value="{{ old('permanent_addr') }}" class="input-shadow edutab @error('permanent_addr') is-invalid @enderror" placeholder="permanent address">
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Mobile (student)</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="text" name="phone" value="{{ old('phone') }}" class="input-shadow edutab @error('phone') is-invalid @enderror" placeholder="student mobile number" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');" required>
                    </div>
                </div>
                <div class="fild_box d-flex mt-2">
                    <div class="col-md-3 col-5 label_div ng-binding"> Email</div>
                    <div class="col-md-9 col-7 input_field">
                        <input type="email" name="email" value="{{ old('email') }}" class="input-shadow edutab @error('phone2') is-invalid @enderror" placeholder="example@gmail.com">
                    </div>
                </div>
                <div class="container text-center">
                    <br />
                    <h5>Click image to upload</h5>
                    <div class="row">
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-4">
                            <div class="image_area">
                                <label for="upload_image">
                                    <img src="/public/assets/img/dashboard/add-user.png" id="uploaded_image" class="img-responsive" />
                                    <div class="overlay"><div class="text">Change</div></div>
                                    <input type="file" name="image" class="image d-none" id="upload_image">
                                </label>
                            </div>
                        </div>
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Crop Image Before Upload</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="" id="sample_image" />
                                            </div>
                                            <div class="col-md-4">
                                                <div class="preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="crop" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>			
                </div>
            </div>
            <div class="modal-footer">
                <div id="addStMsg"></div>
                <div id="addSt_spinner" class="spnr">
                    @include('includes.spinner')
                </div>
                <button type="submit" class="btn btn-info px-5">Submit</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_image').change(function(event){
            var files = event.target.files;
            var done = function(url){
                image.src = url;
                $modal.modal('show');
            };
            if(files && files.length > 0){
                reader = new FileReader();
                reader.onload = function(event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 0.825,
                viewMode: 1,
                preview:'.preview'
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });
        $('#crop').click(function(){
            canvas = cropper.getCroppedCanvas({
                width:435,
                height:525
            });
            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                    var base64data = reader.result;
                    $.ajax({
                        url:'{{ route("UploadStudentPic") }}',
                        method:'POST',
                        data:{_token:'{{ csrf_token() }}',image:base64data},
                        success:function(data){
                            $modal.modal('hide');
                            $('#uploaded_image').attr('src', '/public/uploads/temps/'+data);
                            $('#photo').val(data);
                        }
                    });
                };
            });
        });
    });
</script>
@endsection