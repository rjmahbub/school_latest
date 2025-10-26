@extends('layouts.master') 
@section('title','Dashboard')
@section('content')
<iframe src="{{ route('includeDashboard') }}" style="display: block;height:calc(100vh - 85px);"></iframe>
@endsection