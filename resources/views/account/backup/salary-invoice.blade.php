@extends('layouts.iframe')
@section('title','invoice')
@section('content')
<div class="card">
    <div class="card-body">
        @if(isset($invoice))
        <div style="max-width: 500px;margin:auto;border: 1px solid #ddd;padding: 20px;">
            @if($invoice)
            <p class="text-center"><span style="font-size:20px">{{ $inst->inst_name }}</span> <br> {{ $inst->inst_addr }}</p>
            <p class="text-center"><b>INVOICE</b></p>
            <hr>
            <p>Student Name : {{ $invoice->full_name }} <br> Father : {{ $invoice->father }}</p>
            <div class="bootstrap-table bootstrap4 mx-auto">
                <table class="table table-stripend">
                    <thead>
                        <tr>
                            <th class="text-center">Month</th>
                            <th class="text-center">Salary Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">{{ date('F Y',strtotime($invoice->month)) }}</td>
                            <td class="text-center">{{ $invoice->amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <img src="" alt="Unpaid Logo">
            @endif
        </div>
        @endif

        @if(isset($invoiceArr))
        <table class="table bordered">
            <thead>
                <tr>
                    <th>Roll</th>
                    <th>Name</th>
                    <th>Father</th>
                    <th>Phone</th>
                    <th>Phone(Guardian)</th>
                    <th>Pay Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceArr as $invoice)
                <tr class="@if($invoice->pay_status == 'Paid') table-success @else table-danger @endif">
                    <td>{{ $invoice->roll }}</td>
                    <td>{{ $invoice->full_name }}</td>
                    <td>{{ $invoice->father }}</td>
                    <td>{{ $invoice->phone }}</td>
                    <td>{{ $invoice->phone2 }}</td>
                    <td>{{ $invoice->pay_status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection