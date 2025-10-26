@extends('layouts.iframe')
@section('title','Change Info')
@section('content')
<div style="max-width:650px; margin:auto;">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Website Custom Header</h3>
		</div>
        <form style="max-width:770px;margin:auto;" action="{{ route('WebHeader') }}" method="post">
            @csrf
            <div class="card-body">
                <textarea id="WebHeader" name="WebHeader">{{ $info->web_head }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Save</button>
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $('#WebHeader').summernote({
                    placeholder: 'Type here',
                    tabsize: 1,
                    height: 250
                });
            });
        </script>
    </div>
</div>
<br>
<br>
<div style="max-width:650px; margin:auto;">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Institute Information</h3>
		</div>
        
        <form id="slpf" action="{{ route('ChangeInfo') }}" method="POST" enctype="multipart/form-data">
         @csrf
         <div class="card-body">
            <div class="form-group">
                <label for="inst_name">Institute Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                    </div>
                    <input type="text" name="inst_name" id="inst_name" value="{{ $info->inst_name }}" class="form-control @error('inst_name') is-invalid @enderror" placeholder="institute name" required>
                    @error('inst_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="inst_addr">Institute Address</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                    </div>
                    <input type="text" name="inst_addr" id="inst_addr" value="{{ $info->inst_addr }}" class="form-control @error('inst_addr') is-invalid @enderror" placeholder="institute address" required>
                    @error('inst_addr')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="inst_phone">Institute Phone</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" name="inst_phone" id="inst_phone" value="{{ $info->inst_phone }}" class="form-control @error('inst_phone') is-invalid @enderror" placeholder="phone number"  maxlength="11" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" required>
                    @error('inst_phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="inst_phone2">Institute Phone Alternative</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" name="inst_phone2" id="inst_phone2" value="{{ $info->inst_phone2 }}" class="form-control @error('inst_phone2') is-invalid @enderror" placeholder="alternative phone number"  maxlength="11" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}">
                    @error('inst_phone2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="inst_email">Institute Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="inst_email" id="inst_email" value="{{ $info->inst_email }}" class="form-control @error('inst_email') is-invalid @enderror" placeholder="institute email address">
                    @error('inst_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Institute Logo</label>
                <?php
                    if($info->logo !== null){
                        $logo = '/public/uploads/{{ $prefix }}/others/{{ $info->logo }}';
                    }else{
                        $logo = '/public/uploads/common/logo.png';
                    }
                ?>
                <div class="input-group mb-3">
                    <input class="w-100" type="file" name="photo" id="InstLogo" />
                    <div class="w-100"><img style="width:150px; height:150px;" id="InstLogo_preview" src="{{ $logo }}" /></div>
                    <span style="position: absolute;top: 50%;left: 33px;" class="text-danger" id="InstLogo_msg"></span>
                    @error('photo')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <div id="editMessage" class="font-weight-bold"></div>
                <div id="edit_spinner" style="width:35px;height:35px;display:none;">
                    @include('includes.spinner')
                </div>
               <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Update</button>
            </div>
         </div>
        </form>
   </div>
</div>
<script>
    $("#slpf").on('submit',(function(e) {
      e.preventDefault();
      $("#editMessage").empty();
      $('#edit_spinner').show();
      $.ajax({
         url: "{{ route('ChangeInfo') }}",
         type: 'POST',
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData:false,
         success: function(result){
            $("#editMessage").html(result);
            $('#edit_spinner').hide();
        }
      })
    }))
</script>
@endsection