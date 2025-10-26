@extends('layouts.iframe')
@section('title','Packages')
@section('content')
<div class="bootstrap-table bootstrap4">
    <div class="fixed-table-container pb-0">
        <div class="fixed-table-body">
            <table class="table table-bordered table-hover">
                <thead class="" style="">
                    <tr>
                        <th><div class="th-inner text-center">Package ID</div></th>
                        <th><div class="th-inner text-center">Name</div></th>
                        <th><div class="th-inner text-center">Price</div></th>
                        <th><div class="th-inner text-center">Details</div></th>
                        <th><div class="th-inner text-center">Actions</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                    <tr data-index="0">
                        <td class="text-center">{{ $package->id }}</td>
                        <td class="text-center">{{ $package->name }}</td>
                        <td class="text-center">{{ $package->price }}</td>
                        <td>
                            @php
                                $array = explode(',',rtrim($package->details,','));
                            @endphp
                            <ul style="list-style:none;" class="m-0">
                            @foreach($array as $sa)
                                @php
                                    $data = explode('::',$sa);
                                @endphp
                                <li><i class="fa @if($data[1] == 'true') fa-check text-success @else fa-times-circle text-danger @endif"></i> {{ $data[0] }}</li>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0)" data-table="packages" data-col="id" data-val="{{ $package->id }}" class="Delete"><i class="fa fa-trash text-danger"></i></a>
                            <a href="{{ route('editPackage') }}?id={{ $package->id }}" class="Edit ml-3"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="fixed-table-footer"></div>
    </div>
</div>
<script>
    $('.Delete').click(function(){
        var x = $(this).attr('data-table'),
            y = $(this).attr('data-col'),
            z = $(this).attr('data-val');
        Swal.fire({
        title: 'Are you sure to delete?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('DeleteByIds') }}",
                type: 'POST',
                data: {_token:'{{ csrf_token() }}', table:x, col:y, ids:''+z+''},
                success: function(result){
                    if(result == true){
                        Swal.fire(
                            'Deleted!',
                            'success',
                            'success'
                        );
                        location.reload();
                    }else{
                        Swal.fire(
                            'Delete Failed!',
                            '',
                            'error'
                        )
                    }
                },
                error: function(){
                    Swal.fire(
                        'Error!',
                        '',
                        'error'
                    )
                }
            })
        }})
    })
</script>
@endsection