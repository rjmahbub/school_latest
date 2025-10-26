@extends('layouts.iframe')
@section('title','Profile')
@section('content')
<div style="max-width:500px; margin:auto;">
    <div class="card">
		<div class="card-header">
			<h3 class="card-title">User Profile</h3>
            <button id="edit" style="width: 75px;font-size: 17px;border-radius:25px;" class="float-right"><i class="fa fa-edit"></i> Edit</button>
		</div>
        <form id="UpdateProfile" action="{{ route('UpdateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
		<div class="card-body">
        <table class="table table-striped">
            <tbody>
                <tr>
                <td colspan="2">
                    <div class="row">
                        <div class="container text-center">
                            <br />
                            <h5>Click image to upload</h5>
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                                <div class="col-md-4">
                                    <div class="image_area">
                                        <label for="upload_image">
                                            <img src="/public/uploads/users/{{ $user->photo }}" onerror="this.src='/public/uploads/common/blank-user.png'" id="uploaded_image" class="img-responsive img-circle" />
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
                </td>
                </tr>
                <tr>
                <th class="pt-3">Nick Name :</th>
                <td><input type="text" name="nick_name" id="nick_name" value="{{ $user->nick_name }}" class="form-control st_inputs"></td>
                </tr>
                <tr>
                <th class="pt-3">Gender :</th>
                <td>
                    <select name="gender" id="gender" class="custom-select st_inputs @error('gender') is-invalid @enderror">
                        <option value="">Select...</option>
                        <option value="Male" @if($user->gender == 'Male') selected @endif>Male</option>
                        <option value="Female" @if($user->gender == 'Female') selected @endif>Female</option>
                        <option value="Others" @if($user->gender == 'Others') selected @endif>Others</option>
                    </select>
                </td>
                </tr>
                <tr>
                <th class="pt-3">Phone Number :</th>
                <td><input type="number" name="phone" id="phone" value="{{ $user->phone }}" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');" class="form-control st_inputs"></td>
                </tr>
                <tr>
                <th class="pt-3">Email :</th>
                <td><input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control st_inputs"></td>
                </tr>
            </tbody>
        </table>
        </div>
        
        <div class="modal-footer">
            <div id="edit_spinner" style="width:35px;height:35px;display:none;" class="ml-3">
                @include('includes.spinner')
            </div>
            <input type="submit" class="btn btn-primary st_inputs" value="Save Changes">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.st_inputs').css({'background':'transparent','border':'none'}).attr('disabled',true);

    $('#edit').click(function(){
      $('#photo').show();
      $('#edit_spinner').hide();
      $('.st_inputs').css({'background':'','border':''}).attr('disabled',false);
      $('#edit_full_name').focus();
   });

    $("#UpdateProfile").submit(function( event ) {
        $('#edit_spinner').show();
    });
})
</script>
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
                aspectRatio: 1,
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
                var id = {{ Auth::user()->id }};
                $.ajax({
                    url:'{{ route("ChangePhoto") }}',
                    method:'POST',
                    data:{_token:'{{ csrf_token() }}',table:'users',col:'photo',id:id,image:base64data},
                    success:function(data){
                        $modal.modal('hide');
                        $('#uploaded_image').attr('src', '/public/uploads/users/'+data);
                        $('#TeacherTable').bootstrapTable('refresh');
                    }
                });
                };
            });
        });
    });
</script>
@endsection