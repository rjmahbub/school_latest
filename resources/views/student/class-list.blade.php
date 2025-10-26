@extends('layouts.iframe')
@section('title','Class List')
@section('content')
<?php
   $session = $request->session?:$CurrentSession;
?>
<ul id="iframeMenu" class="p-0 m-0">
   <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
      <ul id="iframeNavigation" class="mb-0">
            <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
            <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
            <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
      </ul>
   </div>
   <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">STUDENT</div>
   <li><a class="active">Classwise Students</a></li>
   <li><a href="{{ route('onlineAdmittedList') }}">None Approval</a></li>
</ul>
<div class="row">
   <div class="ml-3">
      <form action="" class="mt-3">
         <input type="text" name="session" value="{{ $session }}" placeholder="session">
         <input type="submit" value="GO">
      </form>
      @foreach($classes as $class)
      
      <?php 
         $whereArr = ['class_id'=>$class->class_id,'session'=>$session];
      ?>
      @if(isset($groups))
      <div class="rhombusMain hoverHere">
         <div class="rhombusDiv">
            <rhombus>
               <img class="rhombusPic" src="/public/assets/img/0.png">
               <p class="m-0" style="transform: rotate(-45deg);position: relative;top: -37px;left: 3px;font-size: 13px;color: #fff;text-align: center;">{{ $class->class_name }}</p>
            </rhombus>
            <div class="mt">
               <h5 class="cls">{{ strtoupper($class->class_name) }}</h5>
               <h6 class="st_count">Students : <i class="fa fa-mouse-pointer" aria-hidden="true"></i></h6>
            </div>
         </div>
         <div style="width:150px;margin:0 auto;" class="hoverShow">
            @foreach($groups as $group)
            <?php $whereArr['grp_id'] = $group->grp_id; ?>
            <a href="{{ route('students') }}?class_id={{ $class->class_id }}&grp_id={{ $group->grp_id }}&session={{ $session }}"><button class="btn groupTx">{{ $group->grp_name }} [{{ \App\Helpers\SiteHelper::CountData('admissions',$whereArr) }}]</button></a>
            @endforeach
         </div>
      </div>
      @else
      <div class="rhombusMain">
         <a href="{{ route('students') }}?class_id={{ $class->class_id }}&grp_id=2&session={{ $session }}">
            <div class="rhombusDiv">
               <rhombus>
                  <img class="rhombusPic" src="/public/assets/img/0.png">
                  <p class="m-0" style="transform: rotate(-45deg);position: relative;top: -37px;left: 3px;font-size: 13px;color: #fff;text-align: center;">{{ $class->class_name }}</p>
               </rhombus>
               <div class="mt">
                  <h5 class="cls">{{ strtoupper($class->class_name) }}</h5>
                  <h6 class="st_count">Students : <span class="Count">{{ \App\Helpers\SiteHelper::CountData('admissions',$whereArr) }}</span></h6>
               </div>
            </div>
         </a>
      </div>
      @endif
      @endforeach


   </div>
   <script type="text/javascript">
      $(document).ready(function(){
         $(".rhombusMain").hover(
            function () {
               $(this).children("a").children("div").children("rhombus").children("img").addClass("rotate315");
               $(this).children("a").children("div").css("background-color","#fff")
            }, 
            function () {
               $(this).children("a").children("div").children("rhombus").children("img").removeClass("rotate315");
               $(this).children("a").children("div").css("background-color","")
            }
         );
      });
   </script>
</div>
@endsection