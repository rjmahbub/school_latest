<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
	<link rel="stylesheet" href="/assets/css/custom_responsive.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        ul.desktopLi>a>li{
          width: 100%;
          height: 40px;
          background: #fbfbfb;
          border-bottom: 1px solid #ddd;
          padding: 13px;
        }
    </style>
</head>
<body class="mtn">
  <div class="desktop">
    <div class="desktopView" style="width:180px;position:fixed;top: 0;left: 0;height: 100vh;color: #000;z-index: 800;">
      <div style="width: 100%;height: 100%;position: absolute;top: 0;left: 0;z-index: 0;">
        <div style="overflow:hidden;height:120px;" class="nevigation-header">
          <img style="width: 80px;border-radius: 100%;margin:10px auto;" src="/uploads/users/admin/Mahbub.jpg" alt="">
          <p class="text-center">{{ Auth::user()->nick_name }}</p>
        </div>
        <div style="height:calc(100vh - 120px);overflow:hidden;overflow-y:auto;">
          <ul class="desktopLi">
              <a href="{{route('rp')}}"><li>Result Publish</li></a>
              <a href="/result/show"><li>Show Result</li></a>
              <a href="/profile/update"><li>Profile Update</li></a>
              <a href=""><li>4</li></a>
              <a href=""><li>5</li></a>
              <a href=""><li>6</li></a>
              <a href="/logout"><li>Logout</li></a>
          </ul>
        </div>
      </div>
    </div>
  </div>
    <section class="mobileView" id="mobileView">
        <div id="navigation-bar" class="navigation-bar" style="overflow: hidden;">
        <div class="navbox menu1" style="position: absolute;width: 60%;bottom: 120px;left: 3px; display: block;">
            <div class="navbox-tiles">
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-home"></i></div>
                <span class="title">Home</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <span class="title">Calendar</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-envelope-o"></i></div>
                <span class="title">Email</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-file-image-o"></i></div>
                <span class="title">Photos</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-cloud"></i></div>
                <span class="title">Weather</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-file-movie-o"></i></div>
                <span class="title">Movies</span>
            </a>
            </div>
        </div>

        <div class="navbox menu2" style="position: absolute;width: 60%;bottom: 120px;left: 3px;">
            <div class="navbox-tiles">
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-home"></i></div>
                <span class="title">Home</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <span class="title">Calendar</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-envelope-o"></i></div>
                <span class="title">Email</span>
            </a>
            <a href="javascript:void(0)" class="tile">
                <div class="icon"><i class="fa fa-file-image-o"></i></div>
                <span class="title">Photos</span>
            </a>
            </div>
        </div>
        
        <!--background-image: linear-gradient(90deg, #0695da, #740ace);
        margin-left: -15px;-->
    
        <div id="main_menu" style="overflow: scroll;overflow-x: hidden;background-image: linear-gradient(90deg, #494d63, #7d86af);border-bottom-left-radius: 22px;border-top-left-radius: 22px;height: calc(100vh - 96px);width: 40%;position: absolute;right: 0;padding: 0;" class="navbox-tiles">
            <div style="overflow:hidden;height:13px;"></div>
            <div style="height:calc(100vh - 120px);overflow:hidden;overflow-y:auto;">
            <ul id="menu_li" style="list-style:none;width: 100%;padding-left: 13px;">
                <li id="menu6" class="menu" style="margin-top: 0;">Menu 1</li>
                <li id="menu5" class="menu">Menu 2</li>
                <li id="menu4" class="menu">Menu 3</li>
                <li id="menu3" class="menu">Menu 7</li>
                <li id="menu2" class="menu">Menu 8</li>
                <li id="menu1" class="menu MainMenuActive"><i class="fa fa-user menu_icon"></i><span style="padding-left: 35px;"> Menu 19</span></li>
            </ul>
            </div>
        </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#main_menu ul li').click(function(){
            $(this).addClass('MainMenuActive').siblings().removeClass('MainMenuActive');
            });
            
            var a = $('#main_menu').height();
            var b = $('#menu_li').height();
            var c = a-b-25;
            if(a>b){
            //$('#menu_li').css('margin-top',c+'px');
            }
            $('#menu_li li').click(function(){
            var menuId = $(this).attr('id');
            $('.navbox').hide();
            $('.'+menuId).show();
            });
        });
        </script>
        <nav>
        <div class="wave-wrap">
            <svg version="1.1" id="wave" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 119 26" style="left: 131.992px;">
                <path class="path" d="M120.8,26C98.1,26,86.4,0,60.4,0C35.9,0,21.1,26,0.5,26H120.8z"></path>
            </svg>
        </div>
    
        <ul class="list-wrap">
            <li data-color="#eccc68" title="Home">
            <i class="fa fa-home"></i>
            </li>
            <li data-color="#ff6b81" title="Profile">
            <i class="fa fa-user"></i>
            </li>
            <li id="menu" data-color="#7bed9f" title="Menu" class="active">
            <i class="fa fa-lg fa-th"></i>
            </li>
            <li data-color="#70a1ff" title="Files">
            <i class="fa fa-folder"></i>
            </li>
            <li data-color="#dfe4ea" title="Settings">
            <i class="fa fa-cogs"></i>
            </li>
        </ul>
        </nav>
    
    <script>
        (function () {
        $(document).ready(function () {
            $('#menu').click(function () {
                $('#navigation-bar').toggleClass('navbox-open');
                //$('#navigation-bar').slideDown();
    
            });
            
            /*return $('document').on('click', function (e) {
                var $target;
                $target = $(e.target);
                if (!$target.closest('.navbox').length && !$target.closest('#menu').length) {
                    return $('#navigation-bar').removeClass('navbox-open');
                }
                
            });*/
        });
        }.call(this));
        $(document).ready(function(){
        $('#menu').click(function(){
            //$('#main_menu').animate({scrollTop:$('#main_menu').height()+1000}, 1500, 'linear');
            //return false;
        });
        });
    </script>
    <script src="/assets/js/mobile_menu.js"></script>
  </section>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@include('sweetalert::alert')
</body>
</html>