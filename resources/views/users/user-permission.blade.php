@extends('layouts.iframe')
@section('title','All User')
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
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">USER & PERMISSION</div>
        <li><a href="{{ route('users') }}">User List</a></li>
        <li><a class="active">Permission</a></li>
    </ul>
    <div class="card-body">
        @if($users->isNotEmpty())
        <table class="w-100 table table-bordered table-responsive text-center">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>User Name</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <form action="{{ route('SaveUserPermission') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <td><img style="width:60px;height:75px;" src="/public/uploads/{{ $prefix }}/users/{{ $user->photo }}" onerror="this.src='/public/uploads/common/blank-user.png'"></td>
                        <td>{{ $user->nick_name }}</td>
                        <td>
                            <div class="text-left">
                                @foreach($menus as $k => $menu)
                                <?php $property = 'm'.$k; ?>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger" type="checkbox" name="cb{{ $k }}" id="m{{ $k }}" @if($user->$property == 1) checked @endif>
                                    <label for="m{{ $k }}" class="custom-control-label">{{ $menu }}</label>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td><button type="submit" class="btn btn-sm btn-success">Save</button></td>
                    </form>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No user available</p>
        @endif
    </div>
</div>
@endsection