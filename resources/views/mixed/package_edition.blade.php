@extends('layouts.iframe')
@section('title','Edit-Package')
@section('content')
<div style="max-width:650px; margin:auto;">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Package Edit</h3>
            <a href="{{ route('packageList') }}" style="position: absolute;top: 4px;right: 1px;width: 80px;font-weight: bold;" class="float-right btn border-warning">List</a>
		</div>
        <form action="{{ route('PackageEditionSave') }}" method="post">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $package->id }}">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="addnew" name="add">
                        <label for="addnew">Add New</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-book"></i></span>
                        </div>
                        <input type="text" name="name" value="{{ $package->name }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-book"></i></span>
                        </div>
                        <input type="text" name="price" value="{{ $package->price }}" class="form-control">
                    </div>
                </div>

                <label for="details">Details</label>
                <textarea style="width:100%;height:150px;" name="details">{{ $package->details }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection