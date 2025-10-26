<?php
  use App\Http\Controllers\PublicController;
  $db = new PublicController;
  $user = Auth::user();
  if(empty($user->photo)){
    $gender = $user->gender;
    if($gender == 'male' || $gender == 'Male'){
      $photo = 'common/avatar_male.png';
    }elseif($gender == 'female' || $gender == 'Female'){
      $photo = 'common/avatar_female.png';
    }
  }else{
    $photo = "users/$user->photo";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') | {{ $domainName }}</title>
  <link rel="stylesheet" href="/public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="/public/assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/public/assets/css/dashboard/adminlte.min.css">
	<link rel="stylesheet" href="/public/assets/plugins/main/css/responsive.css">
  <link rel="stylesheet" href="/public/assets/css/dashboard/style.css">
  <link rel="stylesheet" href="/public/assets/plugins/bootstrap-table/css/bootstrap-table.min.css">

  <script src="/public/assets/plugins/jquery/jquery.min.js"></script>
  <script src="/public/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <style>
    .navbar-expand .navbar-nav .nav-link {
      padding-right: .7rem;
      padding-left: .7rem;
    }
    @media only screen and (max-width: 1023px){
      .navbar-light .navbar-nav .nav-link{
        color: #d3cccc;
      }
      .navbar-light .navbar-nav .nav-link:hover{
        color: #a3a3a3;
      }
      .navbar-light .navbar-nav .nav-link:focus{
        color: #d3cccc;
      }
      .clr{color:#d3cccc;}
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
  <nav class="main-header navbar navbar-expand navbar-white navbar-light p-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" onclick="window.open('https:\/\/'+'{{ $domainName }}')" class="nav-link">Go Website</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="location.reload()" role="button">
          <i class="fas fa-home"></i>
        </a>
      </li>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/public/assets/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/public/assets/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/public/assets/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-cogs"></i>
        </a>
      </li>
      <li style="margin-right: 10px;" class="nav-item">
        <div class="dropdown show">
          <div class="dropdown-toggle clr" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img style="width: 40px; height:40px; border-radius: 50%;border:1px solid #bbbec1;padding:2px;float:left;" src="/public/uploads/{{ $photo }}" alt="photo">
            <span class="d-none d-sm-inline-block pt-2">{{ Auth::user()->nick_name }}</span>
          </div>
          <div style="left:initial;right:0 !important;" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            @if($user->who == 1 || $user->who == 3)
            <a class="dropdown-item" href="#">Balance: {{ $user->balance }}</a>
            <a class="dropdown-item" href="{{ route('payment') }}">Payment</a>
            <hr class="my-1">
            @endif
            <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
            <a class="dropdown-item" href="{{ route('ChangePwdForm') }}">Change Password</a>
            <hr class="my-1">
            <a class="dropdown-item text-danger" href="#" onclick='window.location.href="{{ route("logout") }}"'>Logout</a>
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link p-0">
      @if(isset($inst->inst_name))
      <marquee>{{ $inst->inst_name }}</marquee>
      @else
      <marquee>{{ $user->nick_name }}</marquee>
      @endif
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <div class="text-center m-2">
          <img class="profile-user-img img-fluid img-circle" src="/public/uploads/{{ $photo }}" alt="photo">
        </div>
        @if($user->who == 1 || $user->who == 7)
        <div class="text-center pb-3">
          @if($user->who == 7)
          <?php $referCode = $db->getAffiliateReferCode(Auth::user()->id); ?>
          <p class="mb-0 text-primary">Refer Code: {{ $referCode }}</p>
          @endif
          <a href="{{ route('AffiliateGeneration') }}" target="_blank"><i class="fa fa-sitemap"></i> Generation</a>
        </div>
        @endif
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="py-3">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
          @if($user->who == 1  || $user->who == 3 || $user->who == 7 )
          <?php
            $array = ['1'=>'cashInFormSuperAdmin','3'=>'InstituteRenewForm','7'=>'cashoutForm'];
          ?>
          <li class="nav-item">
            <a href="{{ route($array[$user->who]) }}" class="nav-link">
              <i class="nav-icon fas fa-universal-access navIcon"></i>
              <p>Apps Account</p>
            </a>
          </li>
          @if($user->who == 1 || $user->who == 7)
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa fa-university nav-icon navIcon"></i>
              <p>Institute <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if($user->who == 7)
              <li class="nav-item">
                <a href="{{ route('DomainRegisterForm') }}?q=1&refer={{ $user->id }}" class="nav-link">
                  <i class="far fa fa-sitemap nav-icon text-warning"></i>
                  <p>Refer Institute</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{ route('InstituteList') }}" class="nav-link">
                  <i class="far fa fa-university nav-icon text-warning"></i>
                  @if($user->who == 1) <p>Institute List</p> @endif
                  @if($user->who == 7) <p>My Refers</p> @endif
                </a>
              </li>
              @if($user->who == 1)
              <li class="nav-item">
                <a href="{{ route('RenewInstSuperAdminForm') }}" class="nav-link">
                  <i class="far fa fa-sync nav-icon text-warning"></i>
                  <p>Renew</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif
          @if($user->who == 1)
          <li class="nav-item">
            <a href="{{ route('packageList') }}" class="nav-link">
              <i class="nav-icon fa fa-gift navIcon"></i>
              <p>Packages</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa fa-dollar-sign nav-icon navIcon"></i>
              <p>Payment <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('AddPaymentInfoForm') }}" class="nav-link">
                  <i class="far fa fa-plus nav-icon text-warning"></i>
                  <p>Add Payment Info</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('PaymentList') }}" class="nav-link">
                  <i class="far fa fa-list nav-icon text-warning"></i>
                  <p>Payment List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('cgseList') }}" class="nav-link">
              <i class="nav-icon fa fa-arrow-down navIcon"></i>
              <p>CGSE Request</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('htmlPages') }}" class="nav-link">
              <i class="nav-icon fa fa-arrow-down navIcon"></i>
              <p>HTML PAGES</p>
            </a>
          </li>
          @endif
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m1 == 1))
          <li class="nav-item">
            <a href="{{ route('teachers') }}" class="nav-link pt-1 pb-1">
              <i class="nav-icon mr-0" style="font-size: 1.15rem;"><img style="width:26px;margin: 0px 4px;float:left;" src="/public/assets/img/teacher.svg" alt=""></i>
              <p>Teachers</p>
            </a>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m2 == 1))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-user-graduate navIcon"></i>
              <p>Students <i class="fas fa-angle-left right"></i></p>
              </p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="{{ route('ClassList') }}" class="nav-link">
                  <i class="nav-icon fas fa fa-circle text-success"></i>
                  <p>Classwise Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('onlineAdmittedList') }}" class="nav-link">
                  <i class="nav-icon fas fa fa-arrow-down text-warning"></i>
                  <p>None Approval</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m11 == 1))
          <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link pt-1 pb-1">
              <i class="nav-icon fa fa-user navIcon"></i>
              <p>Users & Permission</p>
            </a>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m3 == 1))
          <li class="nav-item">
            <a href="{{ route('balanceSheet') }}" class="nav-link">
              <i class="nav-icon fa fa-book navIcon"></i>
              <p>হিসাব-নিকাশ</p>
            </a>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m4 == 1))
          <li class="nav-item">
            <a href="{{ route('makeBillForm') }}" class="nav-link">
              <i class="nav-icon fa fa-dollar-sign navIcon"></i>
              <p>Fee Management</p>
            </a>
            <!-- <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('PaySalaryForm') }}" class="nav-link">
                  <i class="far fa fa-poll-h nav-icon text-warning"></i>
                  <p>Pay</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('CheckSalaryForm') }}" class="nav-link">
                  <i class="far fa fa-poll-h nav-icon text-warning"></i>
                  <p>Check</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('makeBillForm') }}" class="nav-link">
                  <i class="far fa fa-poll-h nav-icon text-warning"></i>
                  <p>Make Bill</p>
                </a>
              </li>
            </ul> -->
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m5 == 1))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-pencil-alt navIcon"></i>
              <p>Generate Paper <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="{{ route('AddMcqForm') }}" class="nav-link">
                  <i class="far fa fa-question nav-icon text-warning"></i>
                  <p>MCQ Question</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m6 == 1))
          <li class="nav-item">
            <a href="{{ route('MonthlyAttendance') }}?ym={{ date('Y-m') }}&type=1" class="nav-link">
              <i class="nav-icon fas fa-clock navIcon"></i>
              <p>Attendance</p>
            </a>
          </li>
          @endif
          @if($user->who == 3 && $user->who == 4 && $user->who == 5 && $user->who == 6)
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book navIcon"></i>
              <p>Academy <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/academy/class-schedule" class="nav-link">
                  <i class="far fa fa-calendar-alt nav-icon text-warning"></i>
                  <p>Class Schedule</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/academy/academic-calendar" class="nav-link">
                  <i class="far fa fa-calendar-alt nav-icon text-warning"></i>
                  <p>Academic Calendar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/academy/book-lish" class="nav-link">
                  <i class="far fa fa-list-ol nav-icon text-warning"></i>
                  <p>Book List</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if($user->who == 5 || $user->who == 6)
          <li class="nav-item">
            <a href="{{ route('myRecentResult') }}" class="nav-link">
              <i class="nav-icon fas fa-book navIcon"></i>
              <p>Recent Result</i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('bill') }}?pending=1" class="nav-link">
              <i class="far fa fa-poll-h nav-icon text-warning"></i>
              <p>Bill</p>
            </a>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m7 == 1))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-university navIcon"></i>
              <p>Result <i class="fas fa-angle-left right"></i></p>
              </p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="{{ route('ResultShowForm') }}" class="nav-link">
                  <i class="nav-icon fas fa fa-circle text-danger"></i>
                  <p>Result Show</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rp') }}" class="nav-link">
                  <i class="nav-icon fas fa fa-arrow-down text-warning"></i>
                  <p>Publish Result</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m8 == 1))
          <li class="nav-item">
            <a href="{{ route('AllNoticeView') }}" class="nav-link">
              <i class="nav-icon fas fa-bell navIcon"></i>
              <p>Notice</p>
            </a>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m9 == 1))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-paint-brush navIcon"></i>
              <p>Site-Design <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="{{ route('ChangeInfoForm') }}" class="nav-link">
                  <i class="nav-icon far fa fa-info text-warning"></i>
                  <p>Change Info</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('SlideshowForm') }}" class="nav-link">
                  <i class="nav-icon far fa fa-images text-warning"></i>
                  <p>Slideshow</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('PhotoGalleryView') }}" class="nav-link">
                  <i class="nav-icon far fa fa-images text-warning"></i>
                  <p>Photo-Gallery</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('VideoGalleryView') }}" class="nav-link">
                  <i class="nav-icon far fa fa-video text-warning"></i>
                  <p>Video-Gallery</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="nav-icon far fa fa-paint-brush text-warning"></i>
                  <p>Themes</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if($user->who == 3 || ($user->who == 4 && $user->m10 == 1))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-university navIcon"></i>
              <p>Hostel Manage. <i class="fas fa-angle-left right"></i></p>
              </p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa fa-arrow-down text-warning"></i>
                  <p>Comming Soon</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if($user->who == 3)
          <li class="nav-item">
            <a href="{{ route('SettingClass') }}" class="nav-link">
              <i class="nav-icon fas fa fa-cogs navIcon"></i>
              <p>Setting & Privecy</p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
      <div class="nav-item dropdown">
        <a style="padding:0.2rem 0.4rem;" class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Close</a>
        <div class="dropdown-menu mt-0">
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Close All</a>
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Close All Other</a>
        </div>
      </div>
      <a style="padding:0.2rem 0.5rem;" class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
      <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
      <a style="padding:0.2rem 0.5rem;" class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
      <a style="padding:0.2rem 0.5rem;" class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
      <script>
        $('#reload').click(function(){
          $('iframe').contentDocument.location.reload(true);
        })
      </script>
    </div>
    <div id="app" style="background:#f4f6f9;" class="tab-content">
      <div style="width: 100%; display: initial; justify-content: initial; align-items: initial;" class="tab-empty">
        @yield('content')
      </div>
        <div style="top: 45%;" class="tab-loading">
          <h2 style="width: 100%;display: flex;justify-content: center;align-items: center;" class="display-4"><i class="fa fa-sync fa-spin"> </i> Loading...</h2>
        </div>
      </div>
    </div>
    </div>
  </div>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<script src="/public/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/public/assets/js/dashboard/theme/adminlte.min.js"></script>
<script src="/public/assets/js/dashboard/theme/demo.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)

  $('.fa-bars').click(function(){
    var x =$('.main-sidebar').width();
    if(x==200){
      $('.profile-username').hide();
    }else{
      $('.profile-username').show();
    }
  })

  $(document).ready(function(){
    setInterval(function() {
      $(".blink").animate({opacity:0},300,"linear",function(){
          $(this).animate({opacity:1},200);
      });
    }, 1500);
  
  })
  window.onload = function () {
    var w = screen.width;
    if (w < 410) {
      var s1 = w / 20,
          s2 = s1 / 10 - 0.05,
          is = s2 * 0.5;
      var vp = document.getElementById('viewport');
      vp.setAttribute('content','width=device-width, initial-scale='+is+',user-scalable=1,minimum-scale=0.5,maximum-scale=1.0');
    }
  }
</script>
@include('sweetalert::alert')
</body>
</html>