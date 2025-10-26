@extends('layouts.iframe')
@section('title','Balance Sheet')
@section('content')
<div style="background:#f4f6f9;" class="card ml-2">
    <ul id="iframeMenu" class="p-0 m-0">
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
            <ul id="iframeNavigation" class="mb-0">
                <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
            </ul>
        </div>
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">হিসাব নিকাশ</div>
        <li><a class="active">Balance Sheet</a></li>
    </ul>
    <div class="card-body">
        <div class="row">
            <div class="col-12 mb-5">
                <style>
                    th{text-align:center;}
                    th,td{padding:5px;border-collapse:collapse;border:1px solid;}
                </style>
                @if(session('success'))
                    <div class="alert table-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert table-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('balanceSheetEntry') }}" method="POST">
                    @csrf
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="mt-1" required>
                    <input type="text" name="remarks" placeholder="details" class="mt-1" required>
                    <input type="number" min="0" name="amount" placeholder="amount" class="mt-1" required>
                    <select name="type" style="padding:2px;" class="mt-1" required>
                        <option value="">type</option>
                        <option value="1">Cost</option>
                        <option value="2">Income</option>
                    </select>
                    <input type="submit" class="mt-1" value="Input">
                </form>
                <hr>
                <br>
                <form action="">
                    <label for="date_from">From</label><input type="date" name="date_from" id="date_from" value="{{ $request->date_from }}">
                    <label for="date_to">To</label><input type="date" name="date_to" id="date_to" value="{{ $request->date_to }}">
                    <input type="submit" value="Get Data">
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Amount</th>
                            @if(Auth::user()->who == 3)
                            <th>Input Time</th>
                            <th>Last Update</th>
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-right" colspan="2"><b>Balance (before {{ $date_from }})</b></td>
                            <td class="text-right table-success">={{ $bbalance }}</td>
                            <td colspan="3"></td>
                        </tr>
                        @foreach($datas as $data)
                        <tr>
                            <td id="date{{ $data->id }}">{{ $data->date }}</td>
                            <td id="remarks{{ $data->id }}">{{ $data->remarks }}</td>
                            <td id="amount{{ $data->id }}" class="text-right @if($data->type == 1) table-danger @endif">{{ $data->amount }}</td>
                            <td id="type{{ $data->id }}" class="d-none">{{ $data->type }}</td>
                            @if(Auth::user()->who == 3)
                            <td class="text-center @if($data->created_at !== $data->updated_at) table-warning @endif">{{ $data->created_at }}</td>
                            <td class="text-center @if($data->created_at !== $data->updated_at) table-warning @endif">{{ $data->updated_at }}</td>
                            <td><a href="javascript:void(0)" class="m-1 delete" data-id="{{ $data->id }}"><i class="fa fa-trash text-danger"></i></a> <a href="javascript:void(0)" data-id="{{ $data->id }}" data-toggle="modal" data-target="#ModalEdition" class="m-1 edit"><i class="fa fa-edit"></i></a></td>
                            @endif
                        </tr>
                        @endforeach
                        <tr>
                            <td class="text-right" colspan="2"><b>Balance (@if($request->date_from && $request->date_to){{ $request->date_to }}@else Current @endif)</b></td>
                            <td class="text-right table-success">={{ $balance }}</td>
                            @if(Auth::user()->who == 3)<td colspan="3"></td>@endif
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h5>Total Credit</h5>
                        <p>{{ $income }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h5>Total Cost</h5>
                        <p>{{ $cost }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h5>Balance</h5>
                        <p>{{ $balance }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal data edition -->
        <div class="modal fade" id="ModalEdition" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 id="StudentName" class="modal-title text-center">Edition Form</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center">
                        <form action="{{ route('balanceSheetEdit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="date" name="date" id="date" class="mt-3">
                            <input type="text" name="remarks" id="remarks" placeholder="details" class="mt-3">
                            <select name="type" id="type" style="padding:2px;" class="mt-3">
                                <option value="">type</option>
                                <option value="1">Cost</option>
                                <option value="2">Income</option>
                            </select>
                            <input type="number" name="amount" id="amount" min="0" placeholder="amount" class="mt-3">
                            <input type="submit" class="mt-3">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('.delete').click(function(){
                var ids = $(this).attr('data-id');
                var tx = $('#remarks'+ids).text();
                Swal.fire({
                title: 'Are you sure to delete this?',
                text: ''+tx+'',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('DeleteByIds') }}",
                            type: 'post',
                            data: {_token:'{{ csrf_token() }}',table:'balance_sheet', col:'id', ids:''+ids+''},
                            success: function(result){
                                if(result == true){
                                    location.reload()
                                }else{
                                    Swal.fire(
                                        'Delete Failed!',
                                        '',
                                        'error'
                                    )
                                }
                            },
                            error: function(e){
                                Swal.fire(
                                    'Error!',
                                    '',
                                    'error'
                                )
                            }
                        })
                    }
                })
            })

            $('.edit').click(function(){
                var id = $(this).attr('data-id'),
                    date = $('#date'+id).text(),
                    remarks = $('#remarks'+id).text(),
                    type = $('#type'+id).text(),
                    amount = $('#amount'+id).text().replace(/-/g, '');
                $('#id,#date,#remarks,#type,#amount').val('');
                $('#id').val(id)
                $('#date').val(date)
                $('#remarks').val(remarks)
                $('#type').val(type)
                $('#amount').val(amount)
            })
        </script>
    </div>
</div>
@endsection