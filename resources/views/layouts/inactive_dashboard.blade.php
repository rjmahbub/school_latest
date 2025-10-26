<?php
  $user = Auth::user();
  if(empty($user->photo)){
    $gender = $user->gender;
    if($gender == 'male' || $gender == 'Male'){
      $photo = 'common/avatar_male.png';
    }elseif($gender == 'female' || $gender == 'Female'){
      $photo = 'common/avatar_female.png';
    }
  }else{
    $photo = "$prefix/users/$user->photo";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Inactive | {{ $domainName }}</title>
  <link rel="stylesheet" href="/public/assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/public/assets/css/dashboard/adminlte.min.css">
  <link rel="stylesheet" href="/public/assets/css/dashboard/style.css">
  <link href="/public/assets/plugins/bootstrap-table/css/bootstrap-table.min.css" rel="stylesheet">

  <script src="/public/assets/plugins/jquery/jquery.min.js"></script>
  <script src="/public/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <style>
    .navbar-expand .navbar-nav .nav-link {
      padding-right: .7rem;
      padding-left: .7rem;
    }
    .navIcon{color: #20befb !important;}
  </style>
</head>
<body style="" class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
<div class="wrapper">
  <!-- Preloader -->
  <div style="background: #ececec !important;" class="preloader flex-column justify-content-center align-items-center">
    <div style="width:60px;height:60px;" class="ml-3">
      @include('includes.spinner')
    </div>
  </div>
  <!-- Navbar -->
  <nav style="margin-left: 0 !important;" class="main-header navbar navbar-expand navbar-white navbar-light p-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="#" class="nav-link text-danger" style="font-weight:bold">Your site is now inactive</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li style="margin-right: 10px;" class="nav-item">
        <div class="dropdown show">
          <div class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img style="width: 40px; height:40px; border-radius: 50%;padding:2px;float:left;" src="/public/uploads/{{ $photo }}" alt="photo">
            <span class="d-none d-sm-inline-block pt-2">{{ Auth::user()->nick_name }}</span>
          </div>
          <div style="left:initial;right:0 !important;" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="#">Balance: {{ $user->balance }}</a>
            <a class="dropdown-item" href="{{ route('payment') }}">Payment</a>
            <a class="dropdown-item" href="{{ route('InstituteRenewForm') }}">Renew</a>
            <hr class="my-1">
            <a class="dropdown-item" href="{{ route('ChangePwdForm') }}">Change Password</a>
            <hr class="my-1">
            <a class="dropdown-item text-danger" href="#" onclick='window.location.href="{{ route("logout") }}"'>Logout</a>
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
</div>
@yield('content')
<script src="/public/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/assets/js/dashboard/theme/adminlte.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
  $(document).ready(function(){
    setInterval(function() {
      $(".blink").animate({opacity:0},300,"linear",function(){
          $(this).animate({opacity:1},200);
      });
    }, 1500);
  })
</script>
@include('sweetalert::alert')
</body>
</html>