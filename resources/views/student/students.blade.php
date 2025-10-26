@extends('layouts.iframe')
@section('title','Students')
@section('content')
<?php
   $session = $request->session?:$CurrentSession;
?>
<div style="background:#f4f6f9;" class="card ml-2">
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
   <div class="card-body">
      @if($request->class_id && $request->session)
         @section("title","$ClassName Students")
         <!-- Modal Table Profile View -->
         <div class="modal fade" id="ModalStudentProfile" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 600px" class="modal-dialog">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h4 class="modal-title text-center">Profile View <button id="edit" style="width: 75px;font-size: 17px;border-radius:25px;"><i class="fa fa-edit"></i> Edit</button></h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                     <form id="EditionFrom" action="{{ route('UpdateStudent') }}" onSubmit="return false" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="st_id" id="st_id" required>
                        <table class="table table-striped">
                           <tbody>
                              <tr>
                                 <td colspan="2">
                                    <div class="row">
                                       <div class="container text-center">
                                          <br />
                                          <h5>Click image to upload</h5>
                                          <div class="row">
                                             <div class="col-md-4">&nbsp;</div>
                                             <div class="col-md-4">
                                                <div class="image_area">
                                                      <label for="upload_image">
                                                         <img src="" onerror="this.src='/public/assets/img/add-user.png'" id="uploaded_image" class="img-responsive">
                                                         <div class="overlay" style="background:#afafafb3;"><div class="text">Change</div></div>
                                                         <input type="file" name="image" class="image d-none" id="upload_image">
                                                      </label>
                                                </div>
                                             </div>
                                          <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                             <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h5 class="modal-title">Crop Image Before Upload</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <div class="img-container">
                                                            <div class="row">
                                                                  <div class="col-md-8">
                                                                     <img src="" id="sample_image" />
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                     <div class="preview"></div>
                                                                  </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" id="crop" class="btn btn-primary" data-dismiss="modal">Save</button>
                                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                      </div>
                                                </div>
                                             </div>
                                          </div>
                                          <script>
                                             $(document).ready(function(){
                                                var $modal = $('#modal');
                                                var image = document.getElementById('sample_image');
                                                var cropper;
                                                $('#upload_image').change(function(event){
                                                      var files = event.target.files;
                                                      var done = function(url){
                                                         image.src = url;
                                                         $modal.modal('show');
                                                      };
                                                      if(files && files.length > 0){
                                                         reader = new FileReader();
                                                         reader.onload = function(event)
                                                         {
                                                            done(reader.result);
                                                         };
                                                         reader.readAsDataURL(files[0]);
                                                      }
                                                });
                                                $modal.on('shown.bs.modal', function() {
                                                      cropper = new Cropper(image, {
                                                         aspectRatio: 0.825,
                                                         viewMode: 1,
                                                         preview:'.preview'
                                                      });
                                                }).on('hidden.bs.modal', function(){
                                                      cropper.destroy();
                                                      cropper = null;
                                                });
                                                $('#crop').click(function(){
                                                   canvas = cropper.getCroppedCanvas({
                                                      width:435,
                                                      height:525
                                                   });
                                                   canvas.toBlob(function(blob){
                                                      url = URL.createObjectURL(blob);
                                                      var reader = new FileReader();
                                                      reader.readAsDataURL(blob);
                                                      reader.onloadend = function(){
                                                         var base64data = reader.result;
                                                         var id = $('#st_id').val();
                                                         $.ajax({
                                                            url:'{{ route("ChangePhoto") }}',
                                                            method:'POST',
                                                            data:{_token:'{{ csrf_token() }}',table:'students',col:'photo',id:id,image:base64data},
                                                            success:function(data){
                                                               $modal.modal('hide');
                                                               $('#uploaded_image').attr('src', '/public/uploads/{{ $prefix }}/students/'+data);
                                                               $('#StudentTable').bootstrapTable('refresh');
                                                            }
                                                         });
                                                      };
                                                   });
                                                });
                                             });
                                          </script>		
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <th scope="row">Name :</th>
                                 <td><input type="text" name="full_name" id="full_name" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Father :</th>
                                 <td><input type="text" name="father" id="father" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Mother :</th>
                                 <td><input type="text" name="mother" id="mother" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Gender :</th>
                                 <td>
                                    <select name="gender" id="gender" class="custom-select st_inputs @error('gender') is-invalid @enderror">
                                       <option value="">Select...</option>
                                       <option value="Male">Male</option>
                                       <option value="Female">Female</option>
                                       <option value="Others">Others</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <th scope="row">Date of Birth :</th>
                                 <td><input type="date" name="dob" id="dob" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Present Address :</th>
                                 <td><input type="text" name="present_addr" id="present_addr" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Permanent Address :</th>
                                 <td><input type="text" name="permanent_addr" id="permanent_addr" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Phone Number :</th>
                                 <td><input type="number" name="phone" id="phone" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');" class="form-control st_inputs"></td>
                              </tr>
                              <tr>
                                 <th scope="row">Email :</th>
                                 <td><input type="email" name="email" id="email" class="form-control st_inputs"></td>
                              </tr>
                           </tbody>
                        </table>
                  </div>
                  <div class="modal-footer">
                     <div id="editMessage" class="font-weight-bold"></div>
                     <div id="spinner" style="width:35px;height:35px;display:none;">
                        @include('includes.spinner')
                     </div>
                  <input type="submit" class="btn btn-primary st_inputs" value="Save Changes">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </div>
                  </form>
               </div>
            </div>
         </div>
         <!-- Modal Table row photo view -->
         <div class="modal fade" id="ModalStudentPhoto" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 400px" class="modal-dialog">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h4 id="StudentName" class="modal-title text-center">Student Name</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body text-center">
                     <img style="width:100%;min-width:120px;min-height:150px;" id="ViewPhoto" src="" alt="photo">
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <!-- Modal Payment check form -->
         <div class="modal fade" id="ModalPaymentCheck" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 400px" class="modal-dialog">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h5 class="modal-title text-center">Salary Payment Check</h5>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body text-center">
                     <form action="{{ route('CheckSalary') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="class_id" value="{{ $request->class_id }}">
                        <input type="hidden" name="grp_id" value="{{ $request->grp_id }}">
                        <input type="hidden" name="session" value="{{ $request->session }}">
                        <input type="month" name="month" value="{{ date('Y-m') }}" class="form-control">
                        <button type="submit" class="btn btn-primary px-4 mt-3">Check</button>
                     </form>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <!-- Modal Admit -->
         <div class="modal fade" id="ModalAdmit" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 400px" class="modal-dialog">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h4 id="StudentName" class="modal-title text-center">Admit Card Generator</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <form action="{{ route('AdmitCard') }}" method="POST" target="_blank">
                     @csrf
                     <div class="modal-body">
                        <div class="form-group">
                           <label for="exam">Select Exam</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                              </div>
                                 <select name="exam" id="exam_id" class="custom-select @error('exam') is-invalid @enderror" required>
                                    <option value=''>Select Exam</option>
                                    @foreach($exams as $exam)
                                    <option value="{{ $exam->exam_name }}">{{ $exam->exam_name }}</option>
                                    @endforeach
                                 </select>
                                 <input type="hidden" name="ids" id="ids">
                              @error('exam')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>

                        <div id="MonthRow" class="form-group">
                           <label for="month">Month <span class="text-danger">*</span></label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="month" id="month" class="custom-select @error('month') is-invalid @enderror">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="August">August</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                              </select>
                              @error('month')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>

                        <div class="form-group">
                           <label for="exam">Exam Year</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                              </div>
                                 <input type="number" list="yearList" name="year" class="form-control" autocomplete="off">
                                 <datalist id="yearList">
                                    <option value="2020"></option>
                                    <option value="2021"></option>
                                 </datalist>
                              @error('exam')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     </div>
                  </form>
                  
               </div>
            </div>
         </div>
         <!-- Modal Student List Prepare Form -->
         <div class="modal fade" id="ModalStListPrepareForm" data-keyboard="false" data-backdrop="static">
            <div style="max-width: 400px" class="modal-dialog">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h4 id="StudentName" class="modal-title text-center">Student-List Prepare Form</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <form id="StudentListPrepareFrom" action="{{ route('ClassList') }}" method="GET">
                     <div class="card-body">
                        <div class="form-group">
                           <label for="session">Session <span class="text-danger">*</span></label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-book"></i></span>
                              </div>
                              <input type="text" name="session" maxlength="7" value="{{ $request->session }}" pattern="[2]{1}[0]{1}[0-9]{2}[-]{1}[0-9]{2}" list="sessions" value="{{ old('session') }}" class="form-control @error('session') is-invalid @enderror" placeholder="enter session" required>
                              <datalist id="sessions">
                                 <?php
                                    $y = date('Y')+2;
                                    for($i=$y; $i>=$y-8; $i--){
                                       $m = substr($i,2)+1;
                                       echo "<option value='$i-$m'>$i-$m</option>";
                                    }
                                    ?>
                              </datalist>
                              @error('session')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>

                        <div class="form-group">
                           <label for="class_id">Class <span class="text-danger">*</span></label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                              </div>
                              <select name="class_id" id="class_id" class="custom-select @error('class_id') is-invalid @enderror" required>
                                 <option value=''>Select Class</option>
                                 @foreach($classes as $class)
                                 <option value="{{ $class->class_id }}" @if($request->class_id == $class->class_id) selected @endif>{{ $class->class_name }}</option>
                                 @endforeach
                              </select>
                              @error('class_id')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>

                        <div class="form-group">
                           <label for="grp_id">Group <span class="text-danger">*</span></label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                                    <div style="width: 38px; height: 38px; padding: 5px; border: 1px solid rgb(221, 221, 221); border-bottom-left-radius: 5px; border-top-left-radius: 5px; display: none;" class="spinner_container">
                                       @include('includes.spinner')
                                    </div>
                              </div>
                              <select name="grp_id" id="grp_id" class="custom-select @error('grp_id') is-invalid @enderror">
                                 <option value="">Select Group</option>
                              </select>
                              @error('grp_id')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        
                        <div class="modal-footer">
                           <div style="width:35px;height:35px;display:none;">
                              @include('includes.spinner')
                           </div>
                           <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <style>
            .table td, .table th {padding: .15rem;}
         </style>
         <div id="toolbar">
            <a href="{{ route('NewStudentForm') }}?class_id={{ $request->class_id }}&grp_id={{ $request->grp_id }}&session={{ $request->session }}" class="btn btn-success mt-1"><i class="fa fa-plus"></i> Student</a>
            <button id="GeneratePaper" class="btn btn-warning dropdown-toggle mt-1" data-toggle="dropdown" title="Generate Paper"><i class="fa fa-list"> Options </i><span class="caret"></span></button>
            <div class="dropdown-menu dropdown-menu-right">
               <button id="idCard" class="dropdown-item" disabled><i class="fa fa-id-card" disabled></i> ID Card</button>
               <button id="admitCard" class="dropdown-item" data-toggle="modal" data-target="#ModalAdmit" href="javascript:void(0)" disabled><i class="fa fa-id-card"></i> Admit Card</button>
               <a class="dropdown-item" data-toggle="modal" data-target="#ModalPaymentCheck" href="javascript:void(0)"><i class="fa fa-dollar-sign"></i> Salary Check</button>
               <a class="dropdown-item" href="{{ route('MeritPrepareForm') }}?class_id={{ $request->class_id }}&class_name={{ $ClassName }}&grp_id={{ $request->grp_id }}&group_name={{ $GroupName }}&session={{ $request->session }}"><i class="far fa fa-arrow-up"></i> Promotion</a>
               <button id="DeleteStudent" class="dropdown-item" href="javascript:void(0)" disabled><i class="fa fa-trash"></i>  Delete</button>
            </div>
            <!-- <button id="MeritPosition" class="btn btn-primary mt-1" data-toggle="modal" data-target="#ModalMeritPosition" disabled><i class="fa fa-graduation-cap"></i> Merit Position</button> -->
            <button id="StudentListPrepare" class="btn btn-primary mt-1" data-toggle="modal" data-target="#ModalStListPrepareForm"><i class="fa fa-filter"></i> Filter</button>
         </div>
         <table
            id="StudentTable"
            data-toolbar="#toolbar"
            data-search="true"
            data-show-refresh="true"
            data-show-columns="true"
            data-show-columns-toggle-all="true"
            data-show-custom-view="true"
            data-custom-view="customViewFormatter"
            data-show-custom-view-button="true"
            data-show-export="true"
            data-export-types="['doc','excel','pdf']"
            data-click-to-select="true"
            data-minimum-count-columns="2"
            data-pagination="true"
            data-side-pagination="server"
            data-id-field="id"
            data-page-list="[10, 25, 50, 100, 150, all]"
            data-show-print="true"
            data-show-header="true"
            data-url="{{ route('StudentsJson').'?session='.$_GET['session'].'&class_id='.$_GET['class_id'].'&grp_id='.$_GET['grp_id'] }}"
            data-response-handler="responseHandler">
         </table>
         <template id="profileTemplate">
         <div class="col-lg-4 col-md-6 col-sm-6 mt-4">
            <div class="card-deck">
               <div class="card b1" style="background:#e9e9e9;">
                  <div class="card-body">
                  <div class="text-center">
                     <img style="width:150px;height:160px;border-radius:5px;margin:auto;" onerror="this.src='/public/uploads/common/photo_blank.png'" src="/public/uploads/{{ $prefix }}/students/%PHOTO%">
                     <h5 class="mb-0">%NAME%</h5>
                     <h6 class="mb-0">ID: %IDN%</h6>
                     <h6>Roll: %ROLL%</h6>
                     <table class="table">
                        <tbody>
                           <tr class="table-Primary">
                              <td>Father:</td>
                              <td>%FATHER%</td>
                           </tr>
                           <tr class="table-secondary">
                              <td>Mother:</td>
                              <td>%MOTHER%</td>
                           </tr>
                           <tr class="table-success">
                              <td>Present Address:</td>
                              <td>%PREADDR%</td>
                           </tr>
                           <tr class="table-danger">
                              <td>Mobile:</td>
                              <td>%PHONE%</td>
                           </tr>
                        </tbody>
                     </table>   
                  </div>
                  
               </div>
            </div>
         </template>
         <script>
            var $StudentTable = $('#StudentTable')
            var $DeleteStudent = $('#DeleteStudent')
            var $SelectToEnable = $('#DeleteStudent,#idCard,#admitCard')
            var selections = []
            
            function getIdSelections() {
            return $.map($StudentTable.bootstrapTable('getSelections'), function (row) {
               return row.id
            })
            }
            
            function responseHandler(res) {
            $.each(res.rows, function (i, row) {
               row.state = $.inArray(row.id, selections) !== -1
            })
            return res
            }
            
            function detailFormatter(index, row) {
            var html = []
            $.each(row, function (key, value) {
               html.push('<p><b>' + key + ':</b> ' + value + '</p>')
            })
            return html.join('')
            }
            
            function operateFormatter(value, row, index) {
               return [
               '<a style="margin: 0 3px 0 3px; font-size:35px;" class="viewProfile" data-toggle="modal" data-target="#ModalStudentProfile" href="javascript:void(0)" title="View Profile">','<i class="fa fa-id-card"></i>','</a> '
               ].join('')
            }
            
            function PhotoFormat(value, row, index) {
               if(row.photo == null){
                  var photo_link = '/public/uploads/common/photo_blank.png';
               }else{
                  var photo_link = '/public/uploads/{{ $prefix }}/students/'+row.photo;
               }
               return [
                  '<a class="ViewPhoto" data-toggle="modal" data-target="#ModalStudentPhoto"><img style="width:60px" src="'+photo_link+'" alt="photo"></a>'
               ].join('')
            }
            
            window.operateEvents = {
            'click .viewProfile': function (e, value, row, index) {
                  $('#st_id,#full_name,#father,#mother,#gender,#dob,#present_addr,#permanent_addr,#phone,#email').val('');
                  if(row.photo == null){
                     src = '/public/assets/img/add-user.png';
                  }else{
                     src = '/public/uploads/{{ $prefix }}/students/'+row.photo;
                  }
                  $('#st_id').val(row.id);
                  $('#full_name').val(row.full_name);
                  $('#father').val(row.father);
                  $('#mother').val(row.mother);
                  //$('#gender option[value='+row.gender+']').attr('selected','selected');
                  $('#gender').val(row.gender);
                  $('#dob').val(row.dob);
                  $('#present_addr').val(row.present_addr);
                  $('#permanent_addr').val(row.permanent_addr);
                  $('#phone').val(row.phone);
                  $('#email').val(row.email);
                  $('#uploaded_image').attr('src',src);
                  $('.st_inputs').css({'background':'transparent','border':'none'}).attr('disabled',true);
                  $('#editMessage').empty();
               },
               'click .ViewPhoto': function (e, value, row, index) {
                  var st = row['full_name'];
                  if(row['photo'] == null){
                     var src = '/public/uploads/common/photo_blank.png';
                  }else{
                     var src = '/public/uploads/{{ $prefix }}/students/'+row['photo'];
                  }
                  $('#ViewPhoto').attr('src',src);
                  $('#StudentName').text(st);
               }
            }
            
            function totalTextFormatter(data) {
            return 'Total'
            }
            
            function totalNameFormatter(data) {
            return data.length
            }
            
            function totalPriceFormatter(data) {
            var field = this.field
            return '$' + data.map(function (row) {
               return +row[field].substring(1)
            }).reduce(function (sum, i) {
               return sum + i
            }, 0)
            }

            function customViewFormatter (data) {
               var template = $('#profileTemplate').html()
               var view = '';
               $.each(data, function (i, row) {
                  view += template.replace('%NAME%', row.full_name)
                  .replace('%IDN%', row.idn)
                  .replace('%ROLL%', row.roll)
                  .replace('%FATHER%', row.father)
                  .replace('%MOTHER%', row.mother)
                  .replace('%PREADDR%', row.present_addr)
                  .replace('%PHONE%', row.phone)
                  .replace('%PHONE2%', row.phone2)
                  .replace('%PHOTO%', row.photo);
               })

               return `<div class="row mx-0">${view}</div>`;
            }
            
            function initTable() {
            $StudentTable.bootstrapTable('destroy').bootstrapTable({

               columns:
               [
                  {
                  field: 'state',
                  checkbox: true,
                  align: 'center',
                  valign: 'middle'
                  },{
                  field: 'operate',
                  title: 'Actions',
                  align: 'center',
                  clickToSelect: false,
                  events: window.operateEvents,
                  formatter: operateFormatter
                  },{
                  field: 'photo',
                  title: 'Photo',
                  align: 'center',
                  clickToSelect: false,
                  events: window.operateEvents,
                  formatter: PhotoFormat
                  },{
                  field: 'roll',
                  title: 'Roll',
                  align: 'center'
                  },{
                  field: 'idn',
                  title: 'ID Number',
                  align: 'center'
                  },{
                  field: 'full_name',
                  title: 'Name',
                  align: 'center'
                  },{
                  field: 'father',
                  title: 'Father',
                  align: 'center',
                  },{
                  field: 'mother',
                  title: 'Mother',
                  align: 'center',
                  },{
                  field: 'gender',
                  title: 'Gender',
                  align: 'center',
                  },{
                  field: 'dob',
                  title: 'Date of Birth',
                  align: 'center',
                  },{
                  field: 'present_addr',
                  title: 'Present Address',
                  align: 'center',
                  },{
                  field: 'phone',
                  title: 'Phone',
                  align: 'center',
                  }
               ]
            })
            $StudentTable.on('check.bs.table uncheck.bs.table ' +
               'check-all.bs.table uncheck-all.bs.table',
            function () {
               $SelectToEnable.prop('disabled', !$StudentTable.bootstrapTable('getSelections').length)
               selections = getIdSelections()
            })
            $StudentTable.on('all.bs.table', function (e, name, args) {
               //console.log(name, args)
            })
            }

            $DeleteStudent.click(function () {
               Swal.fire({
               title: 'Are you sure to delete these?',
               text: '',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, delete these!'
               }).then((result) => {
               if (result.isConfirmed) {
                  var ids = getIdSelections();
                  $.ajax({
                     url: "{{ route('DeleteByIds') }}",
                     type: 'post',
                     data: {_token:'{{ csrf_token() }}',table:'students', col:'id', ids:''+ids+''},
                     success: function(result){
                        if(result == true){
                           Swal.fire(
                              'Deleted!',
                              'success',
                              'success'
                           );
                           $StudentTable.bootstrapTable('remove', {
                              field: 'id',
                              values: ids
                           });
                           $SelectToEnable.prop('disabled', true)
                        }else{
                           Swal.fire(
                              'Delete Failed!',
                              '',
                              'error'
                           )
                        }
                     }
                  });
               }
               })
            })

            $('#idCard').click(function () {
               var ids = getIdSelections();
               window.open('/generate/id-card?ids='+ids+'', '_blank');
            })

            $('#admitCard').click(function () {
               $('#ids').val('');
               var ids = getIdSelections();
               $('#ids').val(ids);
            })
            
            $(function() {
            initTable()
            
            $('#locale').change(initTable)
            })
         </script>
         <script>
         $(document).ready(function(){
            $('.fixed-table-container').prepend('<h5 class="text-center mb-0">Class: {{ $ClassName }} | Group: {{ $GroupName }}</h5><h6 class="text-center">Session: {{ $_GET["session"] }}</h6>');
            $('.bs-bars').css('margin-left','10px');
            var class_id = $("#class_id option:selected").val();
            if(class_id != ''){
               group_load(class_id);
            }

            //Prepare edition form from view
            $('#edit').click(function(){
               $('#editPhoto').show();
               $('#spinner').hide();
               $('.st_inputs').css({'background':'','border':''}).attr('disabled',false);
               $('#full_name').focus();
            });

            //Student edition form submit
            $("#EditionFrom").on('submit',(function(e) {
               e.preventDefault();
               $("#editMessage").empty();
               $('#spinner').show();
               $.ajax({
                  url: "{{ route('UpdateStudent') }}",
                  type: 'POST',
                  data: new FormData(this),
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(result){
                     $("#editMessage").html(result);
                     $('#StudentTable').bootstrapTable('refresh');
                     $('#spinner').hide();
                  }
               })
            }))
         });
         </script>
         @else
   </div>
</div>
@endif
@endsection