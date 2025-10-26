@extends('layouts.iframe')
@section('title','Fee Report')
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
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">FEE MANAGEMENT</div>
        <li><a class="active">Report</a></li>
        <li><a href="{{ route('makeBillForm') }}">Make Bill</a></li>
    </ul>
    <div class="card-body">
        <form action="">
            <select name="class_id" id="class_id" class="mt-2" required>
                <option value="">Select Class</option>
                @foreach($classes as $class)
                <option value="{{ $class->class_id }}" @if($request->class_id == $class->class_id) selected @endif>{{ $class->class_name }}</option>
                @endforeach
            </select>
            <select name="grp_id" id="grp_id" class="mt-2" required>
                <option value="">Select Group</option>
            </select>
            <input type="text" name="session" value="{{ $CurrentSession }}" class="mt-2" placeholder="session" required>
            <input type="submit"value="Get" class="mt-2">
        </form>

        @if($request->bill_id)
        <table class="table table-bordered table-responsive">
            <thead>
                <th>Student Name</th>
                <th>Father</th>
                <th>Address</th>
                <th>Phone (Student)</th>
                <th>Phone (Guardian)</th>
            </thead>
            <tbody>
            @foreach($uppaidStudents as $student)
                <tr>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->father }}</td>
                    <td>{{ $student->present_addr }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->phone2 }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $uppaidStudents->appends(request()->input())->links("pagination::bootstrap-4") }}
        @else
        <table class="table table-bordered table-responsive">
            <thead>
                <th>Bill Number</th>
                <th>Details</th>
                <th>Amount</th>
                <th>Total Student</th>
                <th>Total Paid</th>
                <th>Unpaid Student</th>
                <th>completed</th>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->pay_for }}</td>
                    <td>{{ $data->amount }}</td>
                    <td>{{ $countStudent }}</td>
                    <td>{{ $data->countBill }}</td>
                    <td><a href="?class_id={{ $request->class_id }}&grp_id={{ $request->grp_id }}&session={{ $request->session }}&bill_id={{ $data->id }}">View</a></td>
                    <td>{{ round($data->countBill / $countStudent * 100, 1) }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $datas->appends(request()->input())->links("pagination::bootstrap-4") }}
        @endif
    </div>
</div>
@endsection