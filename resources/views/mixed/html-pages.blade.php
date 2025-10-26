@extends('layouts.iframe')
@section('title','html pages')
@section('content')
@foreach($pages as $page)
<h1>{{ $page->code }}</h1>
@endforeach
@endsection