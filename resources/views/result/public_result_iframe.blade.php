<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="/public/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
    <script src="/public/assets/plugins/jquery/jquery.min.js"></script>
</head>
<body class="p-3">
    @if(isset($_GET['class_id']) && isset($_GET['exam_id']))
    <form action="{{ route('ResultShow') }}" target="_blank" method="POST">
        @csrf
        <h4 class="text-center">{{ $exam_name }} Exam</h4>
        <h5 class="text-center">Class: {{ $class_name }} @if($group_name)| Group: {{ $group_name }}@endif </h5>
        <input type="hidden" name="class_id" value="{{ $_GET['class_id'] }}">
        <input type="hidden" name="grp_id" value="@if(isset($_GET['grp_id'])){{ $_GET['grp_id'] }}@endif">
        <input type="hidden" name="exam_id" value="{{ $_GET['exam_id'] }}">
        <hr class="mb-5">
        <div style="max-width:400px;margin:auto;" class="">
            <div class="form-group">
                <label for="year">Passing Year <span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <input type="number" min="1900" name="year" id="year" class="custom-select @error('year') is-invalid @enderror" required>
                    @error('year')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            @if(isset($_GET['month']))
            <div class="form-group">
                <label for="month">Month <span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <select name="month" id="month" class="custom-select @error('month') is-invalid @enderror">
                        <option value="">Select Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                    @error('month')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            @endif

            <div class="form-group">
                <label for="restype">Result Type <span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                        <div style="width:38px;height:38px;padding:5px;display:none;">
                            @include('includes.spinner')
                        </div>
                    </div>
                    <select name="restype" id="restype" onchange="if(this.value == 1){$('#rollRow').show()}else{$('#rollRow').hide()}" class="custom-select @error('restype') is-invalid @enderror" required>
                        <option value=''>Select Result Type</option>
                        <option value='1'>Individual by Roll</option>
                        <option value='2'>Result Sheet</option>
                    </select>
                    @error('restype')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div id="rollRow" class="form-group">
                <label for="roll">Roll Number</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                    </div>
                    <input type="number" name="roll" id="roll" value="{{ old('roll') }}" class="form-control @error('roll') is-invalid @enderror" placeholder="roll number">
                    @error('roll')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <div style="width:35px;height:35px;display:none;">
                    @include('includes.spinner')
                </div>
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
            </div>
        </div>
    </form>
    @else
        <h5 style="top:45%;">Please select your class and exam</h5>
    @endif
</body>
</html>