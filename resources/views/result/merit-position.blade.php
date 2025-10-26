@extends('layouts.iframe')
@section('title','Merit Position Review')
@section('content')
<div style="background:#f4f6f9;" class="card">
    <div class="card-body">
        @if($merits)
        <div style="max-width:800px;" class="mx-auto p-2">
            <form action="{{ route('MeritPosition') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $request->type }}">
            <h5>Promotion From <span class="text-success">{{ $class_name }} to ...</span></h5>
            <div class="form-group">
                <label for="class_id">Class<span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select name="class_id" id="class_id" class="custom-select @error('class_id') is-invalid @enderror" required>
                        <option value=''>Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="grp_id">Group <span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <div class="spnr">
                            @include('includes.spinner')
                        </div>
                    </div>
                    <select name="grp_id" id="grp_id" class="custom-select @error('grp_id') is-invalid @enderror" required>
                        <option value="">Select Group</option>
                    </select>
                    @error('grp_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="session">Session <span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                    </div>
                    <input type="text" name="session" maxlength="7" list="sessions" value="{{ old('session') }}" class="form-control @error('session') is-invalid @enderror" placeholder="enter session" autocomplete="off" required>
                    <datalist id="sessions">
                        <?php
                        $y = date('Y')+2;
                        for($i=$y; $i>=$y-8; $i--){
                            $m = substr($i,2)+1;
                            echo "<option value='$i-$m'>$i-$m</option>";
                        }
                        ?>
                    </datalist>
                    @error('session')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <br>
            <ul>
                <li class="text-danger">leave blank new-roll field if student promotion cancel.</li>
            </ul>
            <div style="overflow:scroll" class="bootstrap-table bootstrap4">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center p-2">Name</th>
                            <th class="text-center p-2">New Roll</th>
                            <th class="text-center p-2">Previous Roll</th>
                            @if($request->type == 'auto')
                            <th class="text-center p-2">Subjects</th>
                            <th class="text-center p-2">Total Marks</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($merits as $student)
                        <tr>
                            <td>{{ $student['name'] }}</td>
                            <td class="text-center"><input style="width:70px;" type="number" name="new_roll[]" value="@if($request->type == 'auto'){{ $i }}@else{{ $student['pre_roll'] }}@endif"><input type="hidden" name="student_id[]" value="{{ $student['student_id'] }}"></td>
                            <td class="text-center">{{ $student['pre_roll'] }}</td>
                            @if($request->type == 'auto')
                            <td class="text-center">{{ $student['subs'] }}</td>
                            <td class="text-center">{{ $student['marks'] }}</td>
                            @endif
                        </tr>
                        @php $i++; @endphp
                        @endforeach

                        <!-- @foreach($absence as $ab)
                        <tr>
                            <td>{{ $ab['name'] }}</td>
                            <td class="text-center"><input style="width:70px;" type="number" name="new_roll[]"><input type="hidden" name="student_id[]" value="{{ $ab['student_id'] }}"></td>
                            <td class="text-center">{{ $ab['pre_roll'] }}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{ $ab['marks'] }}</td>
                        </tr>
                        @endforeach -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success px-4" href="{{ route('MeritPrepareForm') }}?class_id={{ $request->class_id }}&class_name={{ $request->class_name }}&grp_id={{ $request->grp_id }}&group_name={{ $request->group_name }}&session={{ $request->session }}"><i class="fa fa-arrow-left"></i> Back</a>
                <button class="btn btn-success px-4" type="submit">Submit</button>
            </div>
            </form>
        </div>
        @else
        <br>
        <h5 class="text-danger">No students or result found!</h5>
        @endif
    </div>
</div>
@endsection