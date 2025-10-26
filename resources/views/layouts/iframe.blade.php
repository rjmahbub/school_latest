<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ $domainName }}</title>
    <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/dashboard/adminlte.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/bootstrap-table/css/bootstrap-table.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link href="/public/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/plugins/dropzone/dropzone.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/dropzone/cropper.css">
    <link rel="stylesheet" href="/public/assets/css/dashboard/style.css">
    
    <script src="/public/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table-custom-view.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table-export.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/tableExport.min.js"></script>
    <script src="/public/assets/plugins/bootstrap-table/js/bootstrap-table-print.min.js"></script>
    <script src="/public/assets/plugins/jsPDF/jspdf.min.js"></script>
    <script src="/public/assets/plugins/jsPDF/jspdf.plugin.autotable.js"></script>
    <script src="/public/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/public/assets/plugins/dropzone/dropzone.min.js"></script>
    <script src="/public/assets/plugins/dropzone/cropper.js"></script>
    <script src="/public/assets/plugins/summernote/summernote.min.js"></script>

    <style>
        .tab-loading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #c3cad4;
        }
    </style>
</head>
<body style="overflow-x: hidden;">
    <div class="tab-loading">
        <h2 style="width:200px;" id="loading">Please Wait</h2>
        <script>
            i = 0;
            setInterval(function() {
            i = ++i % 4;
            $("#loading").html("Please Wait"+Array(i+1).join("."));
            }, 100);
        </script>
    </div>
    @auth()
    <!-- <div class="card pageTitle">
        <div class="card-header py-1">
            <h3 class="card-title">@yield('title')</h3>
            <div class="card-tools">
                <ul id="iframeNavigation" class="mb-0">
                    <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                    <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                    <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
                </ul>
            </div>
        </div>
    </div> -->
    <script>
        var scrollWidth= window.innerWidth-$(document).width()
        $('.pageTitle').css('width','calc(' + '100vw - ' + scrollWidth + 'px)');
    </script>
    @endauth
    @yield('content')
<script src="/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/assets/js/dashboard/theme/adminlte.min.js"></script>
<script src="/public/assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script type="text/javascript">
    /*dynamic photo preview after validation script instruction
        input[type=file] id = idName
        message id = idName_msg
        photo preview id = idName_preview
    */
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
</script>
@include('sweetalert::alert')
<script>
  $(document).ready(function(){
    $('.tab-loading').hide();
  });
</script>
<script>
    $(document).ready(function(){
        var exam_id = $("#exam_id option:selected").text();
        var class_id = $("#class_id option:selected").val();
        var grp_id = $("#grp_id option:selected").val();
        if(exam_id=='Monthly'){
            $("#MonthRow").show();
        }else{
            $("#MonthRow").hide();
        }
        if(class_id != ''){
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
                    $("#grp_id").html(group_options).removeAttr('disabled');
                    $('#grp_id').prev().children('span').show();
                    $('#grp_id').prev().children('div').hide();
                }else{
                    var null_val = "<option value=''>Select Group</option>";
                    $("#grp_id").html(null_val).attr('disabled','true');
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

    $('.duallistbox').bootstrapDualListbox()
</script>
</body>
</html>