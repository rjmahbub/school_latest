@extends('layouts.iframe')
@section('title','Gallery Video')
@section('content')
<link rel="stylesheet" href="/public/assets/css/dashboard/style.css">
<link rel="stylesheet" href="/public/assets/plugins/main/css/style.css">
<script src="/public/assets/plugins/main/js/jquery.fancybox.js"></script>
<form action="" method="POST">
@csrf
<div class="row p-2">
    <div class="col-12 mb-4">
        <input type="submit" class="btn btn-danger" value="Delete" disabled>
    </div>
    @foreach($videos as $video)
    <div class="news-block col-lg-3 col-md-4 col-sm-6 col-6 wow fadeInRight" data-wow-delay="400ms">
        <div class="inner-box">
            <div class="image-box">
                <figure class="image">
                    <a href="blog-single.html"><img src="/public/uploads/{{ $prefix }}/video_gallery/{{ $video->img }}"></a>
                    <a style="width: 50px;margin: auto;position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);" href="{{ $video->link }}" class="play-now" data-fancybox="gallery" data-caption=""><i class="icon flaticon-play-button-3" aria-hidden="true"></i><span class="ripple"></span></a>
                </figure>
            </div>
            <div style="position:absolute;top: -5px;left: 1px;" class="icheck-danger d-inline">
                <input type="checkbox" id="video{{ $video->id }}" name="checkbox[]" value="{{ $video->id }}">
                <label for="video{{ $video->id }}"></label>
            </div>
        </div>
    </div>
    @endforeach
</form>
    <div class="col-12">
        <div style="max-width:600px;" class="card mx-auto">
            <div class="card-header">
                <h4 class="card-title">New Upload</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('VideoGallery') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="link">Youtube or others video link</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                            </div>
                            <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" placeholder="enter link" required>
                            @error('link')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo">Thumbnail Image</label>
                        <div class="input-group">
                            <input type="file" name="photo" required>
                            @error('photo')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <input type="submit" value="Upload" class="btn btn-success px-4 mt-4">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("input:checkbox").change(function() {
        $(".btn-danger").attr("disabled", "true");
        $("input:checkbox:checked").each(function() {
            $(".btn-danger").removeAttr("disabled");
        });
    });
</script>
@endsection