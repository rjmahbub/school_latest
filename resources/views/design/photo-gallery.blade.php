@extends('layouts.iframe')
@section('title','Gallery Photo')
@section('content')
<link rel="stylesheet" href="/public/assets/css/dashboard/style.css">
<link rel="stylesheet" href="/public/assets/plugins/main/css/style.css">
<script src="/public/assets/plugins/main/js/jquery.fancybox.js"></script>
<form action="{{ route('DeleteGalleryPhoto') }}" method="POST">
@csrf
<div class="row">
    <div class="col-12 mb-4">
        <input type="submit" class="btn btn-danger btn-sm" value="Delete" disabled>
    </div>
    @foreach($photos as $photo)
    <div class="gallery-item col-lg-2 col-md-3 col-sm-4 col-6 wow fadeIn">
        <div class="image-box">
            <figure class="image"><img src="/public/uploads/{{ $prefix }}/photo_gallery/{{ $photo->img }}" alt="{{ $photo->img }}"></figure>
            <div class="overlay-box"><a href="/public/uploads/{{ $prefix }}/photo_gallery/{{ $photo->img }}" class="lightbox-image" data-fancybox='gallery'><span class="icon fa fa-expand-arrows-alt"></span></a></div>
        </div>
        <div style="position:absolute;top: -5px;left: 16px;" class="icheck-danger d-inline">
            <input type="checkbox" id="photo{{ $photo->id }}" name="checkbox[]" value="{{ $photo->id }}">
            <label for="photo{{ $photo->id }}"></label>
        </div>
    </div>
    @endforeach
</form>

    <div class="col-12">
        <br>
        <h4>Photo Upload</h4>
        <p>max file size 500 kb</p>
        <form action="{{ route('PhotoGallery') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="photo">
            <input type="submit" value="Upload" class="btn btn-success">
        </form>
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