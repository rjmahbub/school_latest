@extends('layouts.iframe')
@section('title','Bill')
@section('content')
<style>
    a{color:initial;}
    ul#attendanceMenu{display:flex;}
    ul#attendanceMenu>li{list-style:none;cursor: pointer;padding:9px 12px;border-bottom:1px solid #cacedc}
    ul#attendanceMenu>li.active{border: 1px solid #e0dee6;border-bottom: none;}
</style>

<div class="col-lg-12 px-0">
    <div class="card">
        <ul id="attendanceMenu" class="p-0 m-0">
            @if($request->pending)
            <li class="active">Pending <span class="badge badge-danger right">{{ count($datas) }}</span></li>
            <li><a style="padding:11px 0px;" href="{{ route('bill') }}?paid=1">Paid</a></li>
            @else
            <li><a style="padding:11px 0px;" href="{{ route('bill') }}?pending=1">Pending <span class="badge badge-danger right">{{ $count }}</span></a></li>
            <li class="active">Paid</li>
            @endif
        </ul>
        <div class="card-body">
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>Bill No.</th>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Item</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->pay_for }}</td>
                        <td>{{ $data->amount }}</td>
                        @if($request->pending)
                        <td><button class="btn btn-sm btn-success">Pay Now</button></td>
                        @else
                        <td><i class="fa fa-check text-success"> Paid!</i></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection