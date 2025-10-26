<?php
    use App\Http\Controllers\Controller;
    $c = new Controller;
?>
@extends('layouts.iframe')
@section('title','Recent Result')
@section('content')
<div style="background:#f4f6f9;" class="card">
    <div class="card-body">
        @if($data)
        <div class="text-center">
            <h4>{{ $c->ExamNameById($data[0]->exam_id) }} Examination {{ $data[0]->month }} {{ $data[0]->year }}</h4>
            <h6>Published at {{ $data[0]->created_at }}</h6>
        </div>
        <br>
        <table style="max-width:500px;" class="table tabel-striped mx-auto">
            <tbody>
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th class="text-center">Marks</th>
                    </tr>
                </thead>
                @foreach($data as $result)
                <tr>
                    <td>{{ $c->SubNameById($result->sub_id) }}</td>
                    <td class="text-center">{{ $result->marks }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-center"><br><a href="{{ route('ResultShowForm') }}" style="width:100px;margin:auto;">More Result</a></td>
                </tr>
            </tbody>
        </table>
        @else
        <h5 class="text-danger text-center">Not Recent Result</h5>
        @endif
    </div>
</div>
@endsection