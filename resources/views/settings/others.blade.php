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
        <li><a  href="{{ route('SettingClass') }}">Academy</a></li>
        <li><a class="active">Others</a></li>
    </ul>
    <section class="content-header">
        <div class="card mb-0" style="background:#f4f6f9;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3><i class="fa fa-cogs"></i> Signature Upload</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container text-center">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Click image to upload</h5>
                                <div class="image_area">
                                    <form method="post">
                                        <label for="upload_image">
                                            <img style="border:1px solid #ddd" src="/public/uploads/{{ $prefix }}/signature/signature.png" id="uploaded_image" class="img-responsive" />
                                            <div class="overlay"><div class="text">Change</div></div>
                                            <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                                        </label>
                                    </form>
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
            </div>
        </div>
    </section>
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
                    aspectRatio: 3.75,
                    viewMode: 1,
                    preview:'.preview'
                    });
            }).on('hidden.bs.modal', function(){
                    cropper.destroy();
                    cropper = null;
            });
            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:300,
                    height:80
                });
                canvas.toBlob(function(blob){
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                    var base64data = reader.result;
                    $.ajax({
                        url:'{{ route("UploadSignature") }}',
                        method:'POST',
                        data:{_token:'{{ csrf_token() }}',image:base64data},
                        success:function(data){
                            $modal.modal('hide');
                            location.reload()
                            $('#TeacherTable').bootstrapTable('refresh');
                        }
                    });
                    };
                });
            });
        });
    </script>
    <section class="content-header">
        <div class="card" style="background:#f4f6f9;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3><i class="fa fa-cogs"></i> Current Session</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('currentSession') }}" method="POST">
                    @csrf
                    <input type="text" name="session" class="py-1" placeholder="ex: 2021-22" value="{{ $CurrentSession }}" required>
                    <input type="submit" value="Submit" class="btn btn-success">
                </form>
            </div>
        </div>
    </section>
</div>
@endsection