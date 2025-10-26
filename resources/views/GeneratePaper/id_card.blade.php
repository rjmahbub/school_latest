<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
   @font-face {
      font-family: "bangla";
      src: url({{ storage_path('fonts/SolaimanLipi.ttf') }}) format('truetype');
   }
</style>
<style type="text/css">
   img{width:100%;height:100%;}
   .frame3{
      border-color:#9fb7e2 #4785F8;
      border-image:none;
      border-radius: 25px 0 25px 0;
      -moz-border-radius:25px 0 25px 0;
      -webkit-border-radius:25px 0 25px 0;
      border-style:solid;
      border-width:8px;
   }
   .float{display:inline-block !important;}
   br{line-height:1}
</style>
<?php $n = 1; ?>
@foreach($students as $student)
   <?php
      if($student['photo'] == null){
         //$path = base_path().'/public/public/uploads/common/photo_blank.png';
         //background-image:url('{{ base_path() }}\public\public\assets\img\id-card\3.jpg')
         $path = '/public/uploads/common/photo_blank.png';
      }else{
         $path = "/public/uploads/$prefix/students/".$student['photo'];
      }
   ?>
      <div class="frame3 float" style="width:2.5in;height:auto;padding:5px;margin:15px;background-image:url('/public/assets/img/id-card/3.jpg');background-repeat:no-repeat;">	
         <div style="text-align:center;font-weight:bold;font-size:15px;">{{ $inst->inst_name }}</div>
         <div style="text-align:center;font-size:11pt;">{{ $inst->inst_addr }}</div>
         <br>
         <div style="font-size:14px;text-align:center;padding:2px;">ID CARD</div>
         <div style="width:70px;height:80px;margin:auto;box-shadow:0px 1px 3px 3px #ddd"><img src="{{ $path }}" alt=""></div>
         <table style="font-family:bangla;">
            <tbody>
               <tr>
                  <td>
                     <br>
                     <br>
                  </td>
               </tr>
               <tr>
                  <td style="font-size:14px;">ID</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['idn'] }}</td>
               </tr>
               <tr>
                  <td style="font-size:14px;">Name</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['full_name'] }}</td>
               </tr>
               <tr>
                  <td style="font-size:14px;">Father</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['father'] }}</td>
               </tr>
               <tr>
                  <td style="font-size:14px;">Class</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['class_name'] }}</td>
               </tr>
               @if($student['class_name'] !== null)
               <tr>
                  <td style="font-size:14px;">Group</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['group_name'] }}</td>
               </tr>
               @endif
               <tr>
                  <td style="font-size:14px;">Session</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['session'] }}</td>
               </tr>
               <tr>
                  <td style="font-size:14px;">Roll No</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['roll'] }}</td>
               </tr>
               <tr>
                  <td style="font-size:14px;">Mobile</td>
                  <td style="font-size:14px;">:</td>
                  <td style="font-size:14px;">{{ $student['phone'] }}</td>
               </tr>
            </tbody>
         </table>
         <div style="text-align:right;padding-right:10px; margin-top: 10px;">
            <img style="width:100px;height:30px;" src="/public/uploads/{{ $prefix }}/signature/{{ $sig }}" alt="">
            <div style="font-size:14px;">Authority Signature</div>
         </div>
      </div>
   @if($n % 4 == 0)
   <!-- <div style="page-break-before:always;"></div> -->
   @endif
   <?php $n++; ?>
@endforeach

</body>
</html>