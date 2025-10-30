<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background:whitesmoke;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ $domainName }}</title>
    <link href="/public/assets/plugins/main/css/style.css" rel="stylesheet">
	<link href="/public/assets/plugins/main/css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link href="/public/assets/css/site/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/site/toggle_menu.css" >
    <link rel="stylesheet" href="/public/assets/css/site/style.css">
    <link rel="stylesheet" href="/public/assets/plugins/dropzone/dropzone.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/dropzone/cropper.css">
    <link rel="stylesheet" href="/public/assets/css/dashboard/style.css">

    <link rel="stylesheet" href="/public/assets/plugins/bootstrap-table/css/bootstrap-table.min.css">
    <script src="/public/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/public/assets/js/site/aos.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table-export.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/tableExport.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table-print.min.js"></script>
    <script src="/public/assets/plugins/jsPDF/jspdf.min.js"></script>
    <script src="/public/assets/plugins/jsPDF/jspdf.plugin.autotable.js"></script>
    <script src="/public/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/public/assets/plugins/dropzone/dropzone.min.js"></script>
    <script src="/public/assets/plugins/dropzone/cropper.js"></script>
</head>
<body style="background-color:#f2faf5; overflow-y:hidden" class="container myShadow antialiased">
<section class="header">
    <div class="row">
        <?php
            if($inst->logo == null){
                $logo = '/public/uploads/common/header_logo.png';
            }else{
                $logo = "/public/uploads/$prefix/$inst->logo";
            }
        ?>
        <div style="z-index:1;" class="col-md-2 text-center p-2" data-aos="flip-left"  data-aos-duration="2000"><img style="max-width:150px;margin:auto;" src="{{ $logo }}" alt="" /></div>
        <div class="col-md-10">
            @if($inst->web_head == null)
                <div class="text-center mt-lg-4">
                    <h1 data-aos="fade-right"  data-aos-duration="1200">{{ $inst->inst_name }}</h1>
                    <h3 data-aos="fade-left"  data-aos-duration="2000">{{ $inst->inst_addr }}</h3>
                </div>
            @else
                <div class="mt-lg-4" data-aos="fade-right"  data-aos-duration="1200">
                    {!! $inst->web_head !!}
                </div>
            @endif
            
        </div>
    </div>
</section>

<section class="menubar" id="menubar">
    <div class="row" id="navbar">
        <div id="navid" class="col-md-12 p-0">
            <nav style="background-color:#002646;z-index: 0;min-height:45px;" class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand text-warning" href="/">{{ $domainName }}</a>
                <div class="navbar-toggler "  data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="menu">
                        <div class="bit-1"></div>
                        <div class="bit-2"></div>
                        <div class="bit-3"></div>
                    </div>
                </div>
            <div class="collapse navbar-collapse pr-2" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="mb-3 mb-lg-0"><a style="border-left:1px solid #546471" class="text-white p-2" href="/"><i class="fa fa-home"> Home</i></a></li>
                    <li class="mb-3 mb-lg-0"><a style="border-left:1px solid #546471" class="text-white p-2" href="{{ route('onlineAdmissionForm') }}"><i class="fa fa-address-card"> Admission</i></a></li>
                    <li class="mb-3 mb-lg-0"><a style="border-left:1px solid #546471" class="text-white p-2" href="{{ route('PublicResultForm') }}"><i class="fa fa-graduation-cap"> Results</i></a></li>
                    <li class="mb-3 mb-lg-0"><a style="border-left:1px solid #546471" class="text-white p-2" href=""><i class="fa fa-address-card"> Contact</i></a></li>
                    @guest
                    <li class="mb-3 mb-lg-0"><a style="border-left:1px solid #546471" class="text-white p-2" href="{{ route('login') }}"><i class="fa fa-lock"> Login | Registration</i></a></li>
                    @endguest
                    @auth
                    <li class="mb-3 mb-lg-0"><a style="border-left:1px solid #546471" class="text-white p-2" href="{{ route('dashboard') }}"><i class="fa fa-lock"> Dashboard</i></a></li>
                    @endauth
                </ul>
                <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form> -->
            </div>
            </nav>
        </div>
    </div>
</section>
<section>
    @yield('content')
</section>
<section class="footer">
    <div class="row" style="min-height: 120px;background: #002646;color: #d8d8d8;">
        <div style="font-weight:bold;" class="col-md-4 py-4 mb-4">
            <h3 style="border-bottom:1px solid;padding-bottom:10px;width:fit-content" class="mb-2 pl-1">Contact</h3>
            <p style="color:#a7aba9;margin-bottom:8px;padding-left:20px;">{{ $inst->inst_name }}</p>
            <p style="color:#a7aba9;margin-bottom:8px;padding-left:20px;">Mobile: {{ $inst->inst_phone }} {{ ', '.$inst->inst_phone2 }}</p>
            <p style="color:#a7aba9;;margin-bottom:8px;padding-left:20px;">Email: {{ $inst->inst_email }}</p>
        </div>
        <div style="font-weight:bold;" class="col-md-4 py-4 mb-4">
            <h3 style="border-bottom:1px solid;padding-bottom:10px;width:fit-content;" class="mb-2 pl-1">Usefull Links</h3>
            <div><a href="/" style="color:#a7aba9;;margin-bottom:8px;padding-left:20px;">Home</a></div>
            <div><a href="" style="color:#a7aba9;;margin-bottom:8px;padding-left:20px;">Admission</a></div>
            <div><a href="{{ route('PublicResultForm') }}" style="color:#a7aba9;;margin-bottom:8px;padding-left:20px;">Results</a></div>
            <div><a href="{{ route('login') }}" style="color:#a7aba9;;margin-bottom:8px;padding-left:20px;">Login|Registration</a></div>
            <div><a href="" style="color:#a7aba9;;margin-bottom:8px;padding-left:20px;">Contact</a></div>
        </div>
        <div style="font-weight:bold;" class="col-md-4 py-4 mb-4">
            <h3 style="border-bottom:1px solid;padding-bottom:10px;width:fit-content" class="mb-2 pl-1">Facebook Page</h3>
        </div>
        <div style="font-weight:bold;background: linear-gradient(360deg, #0a2e4c, #002e54);" class="col-md-12 py-4 text-center">
            <p style="color:#61e8b0;margin-bottom:8px;">Power by <a class="text-danger" href="https://{{ $mainDomain }}" target="_blank" rel="noopener noreferrer">{{ $mainDomain }}</a></p>
        </div>
    </div>
</section>

<script src="/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/assets/plugins/main/js/jquery.fancybox.js"></script>
<script src="/public/assets/js/site/toggleMenu.js"></script>
<!-- navbar width & sticky while scrolling -->
<script>
/* 	window.onscroll = function() {scrollFunc()};
    var navbar = document.getElementById("navid");
    var sticky = navbar.offsetTop;
    //get header width for navbar width
    var width = $("#menubar").width()+30;
    var navWidth = width +"px";

    function scrollFunc() {
    if (window.pageYOffset >= sticky ) {
        navbar.classList.add("sticky_navbar");
        $(".sticky_navbar").css("width", navWidth);
        $(".navbar").css("background","#0026468a");
    } else {
        navbar.classList.remove("sticky_navbar");
        $(".navbar").css("background","#002646");
    }
    } */
</script>
<!-- Animate os -->
<script type="text/javascript">
    AOS.init();
</script>
<!--Enter Press function-->
<script type="text/javascript">
    /* $('.enter_next').keydown(function (e) {
        if (e.which === 13) {
            var index = $('.enter_next').index(this) + 1;
            $('.enter_next').eq(index).focus();
        }
    });
    
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    }); */

    $(function() {
        $('input[type=file]').change(function() {
            var id = $(this).attr('id');
            $('#'+id+'_msg').empty();
            var addPhoto = this.files[0];
            var addImage = addPhoto.type;
            var addMatch= ['image/jpeg','image/png','image/jpg'];
            if(!((addImage==addMatch[0]) || (addImage==addMatch[1]) || (addImage==addMatch[2]))){
                $('#'+id+'_preview').attr('src','');
                $('#'+id).css('color','red');
                $('#'+id+'_msg').html('invalid photo');
                return false;
            }else{
                var imageReader = new FileReader();
                imageReader.onload = imageIsLoaded;
                imageReader.readAsDataURL(this.files[0]);
                function imageIsLoaded(e) {
                    $('#'+id).css('color','green');
                    $('#'+id+'_preview').attr('src', e.target.result);
                };
            }
        });
    });

    $(document).ready(function(){
        var exam_id = $("#exam_id option:selected").text();
        var class_id = $("#class_id option:selected").val();
        var grp_id = $("#grp_id option:selected").val();
        if(exam_id=='Monthly'){
            $("#MonthRow").show();
        }else{
            $("#MonthRow").hide();
        }

        if(class_id != undefined){
            group_load(class_id);
            subject_load(class_id,grp_id);
        }

        $("#exam_id").change(function(){
            var exam_id = $("#exam_id option:selected").text();
            if(exam_id == 'Monthly'){
                $("#MonthRow").show();
            }else{
                $("#month").val('');
                $("#MonthRow").hide();
            }
        });

        $("#class_id").change(function(){
            var null_val = "<option value=''>Select Subject</option>";
            var class_id = $("#class_id option:selected").val();
            var grp_id = $("#grp_id option:selected").val();
            $('#grp_id').html('').prev().children('div').show();
            $('#grp_id').prev().children('span').hide();
            $("#sub_id").html(null_val);
            group_load(class_id,grp_id);
            subject_load(class_id,grp_id);
            session_load(class_id,null);
        });

        $("#grp_id").change(function(){
            $("#sub_id").html('').prev().children('div').show();
            $('#sub_id').prev().children('span').hide();
            var grp_id = $("#grp_id option:selected").val();
            var class_id = $("#class_id option:selected").val();
            subject_load(class_id,grp_id);
            session_load(class_id,grp_id);
        });
    });

    function group_load(class_id,grp_id){
        $.ajax({
            url: "/group_load?class_id="+class_id,
            data: {_token:'{{ csrf_token() }}'},
            success: function(groups){
                if(groups!=''){
                    var null_val = "<option value=''>Select Group</option>";
                    var group_options = null_val+groups;
                    $("#grp_id").html(group_options).parent().parent().show();
                    $('#grp_id').prev().children('span').show();
                    $('#grp_id').prev().children('div').hide();
                }else{
                    var null_val = "<option value=''>Select Group</option>";
                    $("#grp_id").html(null_val).parent().parent().hide();
                    subject_load(class_id,grp_id);
                }
            }
        })
    }

    function subject_load(class_id,grp_id){
        $('#sub_id').prev().children('span').hide();
        $('#sub_id').prev().children('div').show();
        $.ajax({
            url: "/subject_load?class_id="+class_id+"&grp_id="+grp_id,
            data: {_token:'{{ csrf_token() }}'},
            success: function(subjects){
                if(subjects!=''){
                    var null_val = "<option value=''>Select Subject</option>";
                    var sub_options = null_val + subjects;
                    $("#sub_id").html(sub_options).prev().children('span').show();
                    $('#sub_id').prev().children('div').hide();
                }else{
                    var null_val = "<option value=''>Select Subject</option>";
                    $("#sub_id").html(null_val).prev().children('span').show();
                    $('#sub_id').prev().children('div').hide();
                }
            }
        });
    }

    function session_load(class_id,grp_id){
        $('#session').prev().children('span').hide();
        $('#session').prev().children('div').show();
        $.ajax({
            url: "/session_load?class_id="+class_id+"&grp_id="+grp_id,
            data: {_token:'{{ csrf_token() }}'},
            success: function(session){
                $("#session").val(session).prev().children('span').show();
                $('#session').prev().children('div').hide();
            }
        })
    }

    $('.count').each(function () {
      $(this).prop('Counter',0).animate({
        Counter: $(this).text()
      }, {
        duration: 1500,
        easing: 'swing',
        step: function (now) {
          $(this).text(Math.ceil(now));
        }
      });
    });

    setInterval(function() {
        $(".blink").animate({opacity:0},300,"linear",function(){
            $(this).animate({opacity:1},200);
        });
    }, 1500);

    function cardCollaspFunc(thisClass){
      var thisClass = thisClass.children().find(".fas");
      if(thisClass.hasClass('fa-minus')){
        thisClass.removeClass('fa-minus').addClass('fa-plus');
      }else{
        thisClass.addClass('fa-minus').removeClass('fa-plus');
      }
    }
</script>
@include('sweetalert::alert')
</body>
</html>