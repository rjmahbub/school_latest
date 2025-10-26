@extends('layouts.iframe')
@if($notice)
@section('title','Update Notice')
@else
@section('title','Publish Notice')
@endif
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
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title"><i class="fas fa-bell text-secondary"></i> NOTICE</div>
        <li><a href="{{ route('AllNoticeView') }}">All Notice</a></li>
        <li><a class="active">Add Notice</a></li>
    </ul>
    <div style="max-width:800px;margin:auto;" class="card" style="background:#f4f6f9;">
        <form action="{{ route('AddNotice') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($notice)
            <input type="hidden" name="notice_id" value="{{ $notice->id }}">
            @endif
            <div class="card-body">
                <div class="form-group">
                    <label for="notice_title">Notice Title</label>
                    <div class="input-group ml-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <input type="text" name="notice_title" id="notice_title" class="form-control @error('notice_title') is-invalid @enderror" value="@if($notice) {{ $notice->title }} @endif" placeholder="Notice Title" required>
                        @error('notice_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ml-3">
                    <label style="margin-left:-10px" for="notice_description">Notice Description</label>
                    <textarea name="notice_description" id="notice_description" class="ml-2">@if($notice) {{ $notice->description }} @endif</textarea>
                </div>
                @if($notice)
                    <div class="form-group">
                        <label>File Atachedment</label>
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    @for($i=1;$i<=5;$i++)
                                    @php $p = 'file'.$i; @endphp
                                    @if($notice->$p == null)
                                    <tr>
                                        <td colspan="2"><input type="file" name="file{{ $i }}" class="w-100 m-2"></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td><span>{{ $notice->$p }}</span></td>
                                        <td>
                                            <a href="/public/uploads/{{ $prefix }}/notices/{{ $notice->$p }}" target="_blank" class="btn btn-xs btn-info">View</a>
                                            <a href="/public/uploads/{{ $prefix }}/notices/{{ $notice->$p }}" class="btn btn-xs btn-success" download>Download</a>
                                            <a href="{{ route('DeleteNoticeFile') }}?id={{ $notice->id }}&file=file{{ $i }}&fn={{ $notice->$p }}" class="btn btn-xs btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                <div class="form-group">
                    <label>File Atachedment</label>
                    <div class="ml-2">
                        <input type="file" name="file1" class="w-100 m-2">
                        <input type="file" name="file2" class="w-100 m-2">
                        <input type="file" name="file3" class="w-100 m-2">
                        <input type="file" name="file4" class="w-100 m-2">
                        <input type="file" name="file5" class="w-100 m-2">
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label for=""> <i class="fa fa-list"></i> Notice Pin-up</label>
                    <div class="custom-control custom-switch ml-3">
                        <input type="checkbox" name="notice_exam" id="notice_exam" class="custom-control-input">
                        <label class="custom-control-label" for="notice_exam">Exam</label>
                    </div>
                    <div class="custom-control custom-switch ml-3">
                        <input type="checkbox" name="notice_headline" id="notice_headline" class="custom-control-input" >
                        <label class="custom-control-label" for="notice_headline">Headline</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-info px-4">Save</button>
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $('#notice_description').summernote({
                    placeholder: 'notice description here',
                    tabsize: 1,
                    height: 250
                });
            });
        </script>
    </div>
</div>
@endsection