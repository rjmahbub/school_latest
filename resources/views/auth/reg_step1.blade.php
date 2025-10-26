@extends('layouts.site')
@section('title','Register')
@section('content')
<div class="page-content" style="background-image: url('images/wizard-v3.jpg')">
    <div class="wizard-v3-content">
        <div class="wizard-form">
            <div class="wizard-header">
                <h3 class="heading">User Registration System</h3>
                <p>Fill valid information to go next step</p>
            </div>
            <form class="form-register" action="{{route('reg2')}}" method="post">
                @csrf
				<div id="form-total" role="application" class="wizard clearfix">
					<div class="steps clearfix">
						<ul role="tablist">
							<li role="tab" aria-disabled="false" class="first current" aria-selected="true">
								<a id="form-total-t-0" aria-controls="form-total-p-0"><span class="current-info audible"> </span>
									<div class="title">
										<span class="step-icon"><i class="fa fa-info"></i></span>
										<span style="margin-left:-14px" class="step-text">Information</span>
									</div>
								</a>
							</li>
							<li role="tab" aria-disabled="false">
								<a id="form-total-t-1" aria-controls="form-total-p-1">
									<div class="title">
										<span class="step-icon"><i class="fa fa-search"></i></span>
										<span style="margin-left:8px" class="step-text">Varify</span>
									</div>
								</a>
							</li>
							<li role="tab" aria-disabled="false" class="last">
								<a id="form-total-t-3" aria-controls="form-total-p-3">
									<div class="title">
										<span class="step-icon"><i class="fa fa-user"></i></span>
										<span class="step-text">Confirm</span>
									</div>
								</a>
							</li>
						</ul>
					</div>
					<div class="content clearfix">
						<section id="form-total-p-0" role="tabpanel" aria-labelledby="form-total-h-0" class="body current" aria-hidden="false">
							@if(session('error'))
								<div class="alert alert-danger" role="alert">
									{{ session('error') }}
								</div>
							@endif
							<div class="inner">
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<select name="usr" id="usr" onchange="func2()" class="custom-select @error('usr') is-invalid @enderror" required>
											<option value="" >Select User</option>
											<option value="4" @if( old('usr') == 4 ) selected @endif>Teacher</option>
											<option value="5" @if( old('usr') == 5 ) selected @endif>Student</option>
											<option value="6" @if( old('usr') == 6 ) selected @endif>Guardian</option>
										</select>
										@error('usr')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div id="strow">
									<div class="form-group">
										<label for="roll">Roll Number</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-book"></i></span>
											</div>
											<input type="number" name="roll" id="roll" value="{{ old('roll') }}" class="form-control @error('roll') is-invalid @enderror" placeholder="student's roll number">
											@error('roll')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="form-group">
										<label for="dob">Date of Birth (Student)</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
											</div>
											<input type="date" name="dob" id="dob" value="{{ old('dob') }}" class="form-control">
											@error('dob')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>

								<div id="divPhone" class="form-group">
									<label for="phone">Phone Number</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-phone"></i></span>
										</div>
										<input type="numbdr" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" placeholder="teacher phone number" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'')">
										@error('phone')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
							</div>
						</section>
					</div>
					<div class="actions clearfix">
						<ul role="menu" aria-label="Pagination">
							<li style="margin-right:10px" class="disabled" aria-disabled="true"><a href="javascript:void(0)" role="menuitem">Previous</a></li>
							<li aria-hidden="false" aria-disabled="false"><input style="width:140px;height:45px;" class="btn btn-primary" type="submit" value="Next Step"></li>
						</ul>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		func2()
	})
	function func2(){
		var val = $("#usr option:selected").val();
		if(val=='4'){
			$('#strow').hide();
			$('#divPhone').show();
			$('#roll,#dob').val('').removeAttr('required');
			$('#phone').attr('required','true');
		}else{
			$('#strow').show();
			$('#divPhone').hide();
			$('#roll,#dob').attr('required','true');
			$('#phone').val('').removeAttr('required');
		}
	}
</script>
@endsection