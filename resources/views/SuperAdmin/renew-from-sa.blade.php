@extends('layouts.iframe')
@section('title','Website Renew')
@section('content')
<div style="max-width:500px; margin:auto;">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Renew Your Site</h3>
		</div>
        <div class="card-body">
            <form id="renewForm" action="{{ route('RenewInstSuperAdminForm') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="prefix">Domain Prefix</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i style="font-size:24px;" class="fas fa-globe"></i></span>
                        </div>
                        <input type="text" name="prefix" class="form-control" placeholder="prefix" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="valid_till">Duration</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i style="font-size:24px;" class="fas fa-calendar-alt"></i></span>
                        </div>
                        <select class="custom-select @error('valid_till') is-invalid @enderror" id="valid_till" name="valid_till" required>
                            <option value="">Select option</option>
                            <option value="1" @if(old('valid_till') == '1') {{ 'selected' }} @endif>1 Month</option>
                            <option value="2" @if(old('valid_till') == '2') {{ 'selected' }} @endif>2 Months</option>
                            <option value="3" @if(old('valid_till') == '3') {{ 'selected' }} @endif>3 Months</option>
                            <option value="4" @if(old('valid_till') == '4') {{ 'selected' }} @endif>4 Months</option>
                            <option value="5" @if(old('valid_till') == '5') {{ 'selected' }} @endif>5 Months</option>
                            <option value="6" @if(old('valid_till') == '6') {{ 'selected' }} @endif>6 Months</option>
                            <option value="12" @if(old('valid_till') == '12') {{ 'selected' }} @endif>1 Year</option>
                            <option value="24" @if(old('valid_till') == '24') {{ 'selected' }} @endif>2 Years</option>
                            <option value="36" @if(old('valid_till') == '36') {{ 'selected' }} @endif>3 Years</option>
                            <option value="48" @if(old('valid_till') == '48') {{ 'selected' }} @endif>4 Years</option>
                            <option value="60" @if(old('valid_till') == '60') {{ 'selected' }} @endif>5 Years</option>
                    	</select>
                        @error('valid_till')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Enter Your Password</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i style="font-size:24px;" class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="password">
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex">
                    <div style="width:35px;height:35px;display:none;" class="spinner_container ml-3">
                        @include('includes.spinner')
                    </div>
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#renewForm').submit(function(){
        $('.spinner_container').show();
    })
</script>
@endsection