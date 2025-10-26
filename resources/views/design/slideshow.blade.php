@extends('layouts.iframe')
@section('title','Slideshow')
@section('content')
<style>
    input{width:100%;}
    th{padding: 5px;text-align:center;}
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Slideshow Items</h3>
    </div>
    <div style="overflow:scroll;" class="card-body">
        <div class="bootstrap-table bootstrap4">
            <div class="fixed-table-container" style="padding-bottom: 0px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px" class="p-2">#</th>
                            <th style="min-width: 170px" class="p-2">Picture</th>
                            <th class="p-2">Sequence</th>
                            <th style="min-width: 220px" class="p-2">Upload</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($images as $image)
                            <tr>
                                <form action="{{ route('UpdateSlideItem') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input name="id" type="hidden" value="{{ $image->id }}">
                                    <td>{{ $i }}.</td>
                                    <td><img class="w-100" id="photo{{ $image->id }}_preview" src="/public/uploads/{{ $prefix }}/slideshow/{{ $image->img }}" alt=""></td>
                                    <td><input style="width:90px;" class="text-center p-2" name="sequence" type="number" value="{{ $image->sequence }}" required></td>
                                    <td><input name="slide_photo" id="photo{{ $image->id }}" type="file"></td>
                                    <td class="d-flex">
                                        <button style="height:30px;width: 80px;" class="btn btn-primary" type="submit"><i class="fa fa-save"> Save</i></button>
                                </form>
                                        <form action="{{ route('DeleteSlideItem') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $image->id}}">
                                            <button type="submit" class="btn btn-danger ml-2"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                            </tr>
                            @php $i++ @endphp
                        @endforeach
                        <form action="{{ route('AddSlideItem') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <tr>
                                <td>{{ $i }}.</td>
                                <td><div id="SlidePhoto_msg"></div><img id="SlidePhoto_preview" class="w-100" src="/public/uploads/common/blank-slide-item.png" alt=""></td>
                                <td><input name="sequence" class="text-center p-2" style="font-size:14px;" type="number" placeholder="sequence" required></td>
                                <td><input name="SlidePhoto" id="SlidePhoto" type="file" required></td>
                                <td class="text-center"><button class="btn btn-success p-2 pl-4 pr-4" type="submit"><i class="fa fa-plus"> Add</i></button></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection