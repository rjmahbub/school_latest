<style type="text/css">
   rhombus{
      background: #013f40;
      display: block;
      width: 65px;
      height: 65px;
      -webkit-transform: rotate(45deg);
      border-radius: 12px;
      margin: auto;
      margin-top: 20px;
      transition: 0.5s;
   }
   rhombus>img{width:100%;}
   .rhombusPic{border-radius:12px;-webkit-transform:rotate(-45deg);transition:1s;}
   .rhombusDiv{width:145px;height:135px;box-shadow:5px 5px 5px 5px #b9b9b9;background-color:#f3f2f2;border-radius:5px;}
   .rhombusMain{width:170px;height:165px;margin:auto;float:left;}
   .rotate315{-webkit-transform:rotate(315deg);transition:1.5s;}
   .st_count{width:100%;background-image:linear-gradient(90deg, #00bf3b -20%, #e4ff00 120%);color:#884f4f;position:relative;bottom:13px;left:0;text-align:center;line-height:32px;font-weight:bold;}
   .cls{position:relative;bottom:9px;text-align:center;color:#007bff;}
   .hoverHere:hover .rhombusDiv{opacity:0.2;transition:0.5s;}
   .hoverHere:hover .hoverShow {opacity: 1;}
   .hoverShow {
      transition: 0.7s;
      opacity: 0;
      position: relative;
      bottom: 147px;
      left: -13px;
      text-align: center;
   }
   .mt{margin-top:20px;}
   @media only screen and (max-width: 767px) {
   .st_count{bottom: 4px;}
   .cls{bottom:0;}
   .mt{margin-top:14px;}
   }
</style>
@foreach($classes as $class)
<div class="rhombusMain">
   <a href="/students?class={{ $class->class_id }}&group={{ $class->grp_ids }}&session=">
      <div class="rhombusDiv">
         <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/{{ $class->class_name }}.png"/></rhombus>
         <div class="mt">
            <h5 class="cls">{{ ucwords($class->class_name) }}</h5>
            <h6 class="st_count">Students : <span class="Count"></span></h6>
         </div>
      </div>
   </a>
</div>
@endforeach
<!-- 
<div class="rhombusMain">
   <a href="students.php?class=six&classBn=ষষ্ঠ">
      <div class="rhombusDiv">
         <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/6.png"/></rhombus>
         <div class="mt">
            <h5 class="cls">SIX</h5>
            <h6 class="st_count">Students : <span class="Count"></span></h6>
         </div>
      </div>
   </a>
</div>

<div class="rhombusMain">
   <a href="students.php?class=seven&classBn=সপ্তম">
      <div class="rhombusDiv">
         <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/7.png"/></rhombus>
         <div class="mt">
            <h5 class="cls">SEVEN</h5>
            <h6 class="st_count">Students : <span class="Count"></span></h6>
         </div>
      </div>
   </a>
</div>



<div class="rhombusMain">
   <a href="students.php?class=eight&classBn=অষ্টম">
      <div class="rhombusDiv">
         <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/8.png"/></rhombus>
         <div class="mt">
            <h5 class="cls">EIGHT</h5>
            <h6 class="st_count">Students : <span class="Count"></span></h6>
         </div>
      </div>
   </a>
</div>



<div class="rhombusMain hoverHere">
   <div class="rhombusDiv">
      <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/9.png"/></rhombus>
      <div class="mt">
         <h5 class="cls">NINE</h5>
         <div style="text-align:center;position:relative;bottom:13px;line-height:1.15;color:#880b0b;font-size:14px;font-weight:bold;">
            <div>
               <div style="width:33.33%;float:left;background:#23fd66;">sc</div>
               <div style="width:33.33%;float:left;background:#9ffd23;">hu</div>
               <div style="width:33.33%;float:left;background:#e4ff00;">bs</div>
            </div>
            <div style="width:33.33%;float:left;background:#23fd66;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#9ffd23;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#e4ff00;"><span class="Count"></span></div>
         </div>
      </div>
   </div>
   <div style="width:150px;margin:0 auto;" class="hoverShow">
      <a href="students.php?class=nine&classBn=নবম&dept=sc"><button style="width:100%;margin-top:5px;background:#23fd66;color:#884f4f;font-weight:bold;" class="btn">Science</button></a>
      <a href="students.php?class=nine&classBn=নবম&dept=hu"><button style="width:100%;margin-top:5px;background:#9ffd23;color:#884f4f;font-weight:bold;" class="btn">Humanities</button></a>
      <a href="students.php?class=nine&classBn=নবম&dept=bs"><button style="width:100%;margin-top:5px;background:#e4ff00;color:#884f4f;font-weight:bold;" class="btn">Business Studies</button></a>
   </div>
</div>

<div class="rhombusMain hoverHere">
   <div class="rhombusDiv">
      <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/10.png"/></rhombus>
      <div class="mt">
         <h5 class="cls">TEN</h5>
         <div style="text-align:center;position:relative;bottom:13px;line-height:1.15;color:#880b0b;font-size:14px;font-weight:bold;">
            <div>
               <div style="width:33.33%;float:left;background:#23fd66;">sc</div>
               <div style="width:33.33%;float:left;background:#9ffd23;">hu</div>
               <div style="width:33.33%;float:left;background:#e4ff00;">bs</div>
            </div>
            <div style="width:33.33%;float:left;background:#23fd66;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#9ffd23;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#e4ff00;"><span class="Count"></span></div>
         </div>
      </div>
   </div>
   <div style="width:150px;margin:0 auto;" class="hoverShow">
      <a href="students.php?class=ten&classBn=দশম&dept=sc"><button style="width:100%;margin-top:5px; background:#23fd66;color:#884f4f;font-weight:bold;" class="btn">Science</button></a>
      <a href="students.php?class=ten&classBn=দশম&dept=hu"><button style="width:100%;margin-top:5px; background:#9ffd23;color:#884f4f;font-weight:bold;" class="btn">Humanities</button></a>
      <a href="students.php?class=ten&classBn=দশম&dept=bs"><button style="width:100%;margin-top:5px; background:#e4ff00;color:#884f4f;font-weight:bold;" class="btn">Business Studies</button></a>
   </div>
</div>

<div class="rhombusMain hoverHere">
   <div class="rhombusDiv">
      <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/11.png"/></rhombus>
      <div class="mt">
         <h5 class="cls">ELEVEN</h5>
         <div style="text-align:center;position:relative;bottom:13px;line-height:1.15;color:#880b0b;font-size:14px;font-weight:bold;">
            <div>
               <div style="width:33.33%;float:left;background:#23fd66;">sc</div>
               <div style="width:33.33%;float:left;background:#9ffd23;">hu</div>
               <div style="width:33.33%;float:left;background:#e4ff00;">bs</div>
            </div>
            <div style="width:33.33%;float:left;background:#23fd66;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#9ffd23;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#e4ff00;"><span class="Count"></span></div>
         </div>
      </div>
   </div>
   <div style="width:150px;margin:0 auto;" class="hoverShow">
      <a href="students.php?class=eleven&classBn=একাদশ&dept=sc"><button style="width:100%;margin-top:5px; background:#23fd66;color:#884f4f;font-weight:bold;" class="btn">Science</button></a>
      <a href="students.php?class=eleven&classBn=একাদশ&dept=hu"><button style="width:100%;margin-top:5px; background:#9ffd23;color:#884f4f;font-weight:bold;" class="btn">Humanities</button></a>
      <a href="students.php?class=eleven&classBn=একাদশ&dept=bs"><button style="width:100%;margin-top:5px; background:#e4ff00;color:#884f4f;font-weight:bold;" class="btn">Business Studies</button></a>
   </div>
</div>

<div class="rhombusMain hoverHere">
   <div class="rhombusDiv">
      <rhombus><img class="rhombusPic" src="/public/assets/img/dashboard/12.png"/></rhombus>
      <div class="mt">
         <h5 class="cls">TWELVE</h5>
         <div style="text-align:center;position:relative;bottom:13px;line-height:1.15;color:#880b0b;font-size:14px;font-weight:bold;">
            <div>
               <div style="width:33.33%;float:left;background:#23fd66;">sc</div>
               <div style="width:33.33%;float:left;background:#9ffd23;">hu</div>
               <div style="width:33.33%;float:left;background:#e4ff00;">bs</div>
            </div>
            <div style="width:33.33%;float:left;background:#23fd66;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#9ffd23;"><span class="Count"></span></div>
            <div style="width:33.33%;float:left;background:#e4ff00;"><span class="Count"></span></div>
         </div>
      </div>
   </div>
   <div style="width:150px;margin:0 auto;" class="hoverShow">
      <a href="students.php?class=twelve&classBn=দ্বাদশ&dept=sc"><button style="width:100%;margin-top:5px; background:#23fd66;color:#884f4f;font-weight:bold;" class="btn">Science</button></a>
      <a href="students.php?class=twelve&classBn=দ্বাদশ&dept=hu"><button style="width:100%;margin-top:5px; background:#9ffd23;color:#884f4f;font-weight:bold;" class="btn">Humanities</button></a>
      <a href="students.php?class=twelve&classBn=দ্বাদশ&dept=bs"><button style="width:100%;margin-top:5px; background:#e4ff00;color:#884f4f;font-weight:bold;" class="btn">Business Studies</button></a>
   </div>
</div> -->
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
      
      $('.Count').each(function () {
         $(this).prop('Counter',0).animate({
            Counter: $(this).text()
         }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
               $(this).text(Math.ceil(now));
            }
         });
      });
      
      var width = $(window).width(),
         mrgn = (width/2)-162;
      if(width<=767){
         if(width<=316){
            $(".rhombusMain").css({"margin-left":"5px"});
         }else{
            $(".rhombusMain").css({"margin-left":mrgn});
         }
      }
   });
</script>