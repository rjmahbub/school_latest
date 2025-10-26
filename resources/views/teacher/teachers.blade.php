@extends('layouts.iframe')
@section('title','Teachers')
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
      <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">TEACHER</div>
      <li><a class="active">Teacher List</a></li>
      <li><a href="#">Extra Menu</a></li>
  </ul>
  <div class="card-body">
      <style>
         .table td, .table th {padding: .15rem;}
      </style>
      <div id="toolbar">
         <a href="{{ route('AddTeacherForm') }}" class="btn btn-success"><i class="fa fa-plus"></i> Teacher</a>
         <button id="DeleteTeacher" class="btn btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
      </div>
      <table
         id="TeacherTable"
         data-toolbar="#toolbar"
         data-search="true"
         data-show-refresh="true"
         data-show-columns="true"
         data-show-custom-view="true"
         data-custom-view="customViewFormatter"
         data-show-custom-view-button="true"
         data-show-columns-toggle-all="true"
         data-minimum-count-columns="2"
         data-show-export="true"
         data-click-to-select="true"
         data-export-types="['doc','excel','pdf']"
         data-pagination="true"
         data-page-list="[10, 25, 50, 100, 150, all]"
         data-side-pagination="server"
         data-show-print="true"
         data-url="{{ route('TeachersJson') }}"
         data-response-handler="responseHandler">
      </table>
      <template id="profileTemplate">
      <div class="col-lg-4 col-md-6 col-sm-6 mt-4">
         <div class="card-deck">
            <div class="card b1" style="background:#e9e9e9;">
               <div class="card-body">
               <div class="text-center">
                  <img style="width:150px;height:160px;border-radius:5px;margin:auto" onerror="this.src='/public/uploads/common/photo_blank.png'" src="/public/uploads/{{ $prefix }}/teachers/%PHOTO%">
                  <h5 class="mb-0">%NAME%</h5>
                  <h6>ID: %IDN%</h6>

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
         var $TeacherTable = $('#TeacherTable')
         var $DeleteTeacher = $('#DeleteTeacher')
         var selections = []
         
         function getIdSelections() {
         return $.map($TeacherTable.bootstrapTable('getSelections'), function (row) {
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
         '<a style="margin: 0 3px 0 3px; font-size:35px;" class="viewProfile" data-toggle="modal" data-target="#ModalTeacherProfile" href="javascript:void(0)" title="View Profile">','<i class="fa fa-id-card"></i>','</a> '
         ].join('')
         }
         
         function PhotoFormat(value, row, index) {
            if(row.photo == null){
               var photo_link = '/public/uploads/common/photo_blank.png';
            }else{
               var photo_link = '/public/uploads/{{ $prefix }}/teachers/'+row.photo;
            }
         return [
            '<a class="ViewPhoto" data-toggle="modal" data-target="#ModalTeacherPhoto"><img style="width:60px" src="'+photo_link+'" alt="photo"></a>'
         ].join('')
         }
         
         window.operateEvents = {
            'click .viewProfile': function (e, value, row, index) {
               $('#id,#full_name,#father,#mother,#gender,#dob,#present_addr,#permanent_addr,#phone,#email').val('');
               if(row.photo == null){
                  src = '/public/assets/img/add-user.png';
               }else{
                  src = '/public/uploads/{{ $prefix }}/teachers/'+row.photo;
               }
               $('#id').val(row.id);
               $('#PreviousPhoto').val(row.photo);
               $('#full_name').val(row.full_name);
               $('#father').val(row.father);
               $('#mother').val(row.mother);
               $('#gender').val(row.gender);
               $('#dob').val(row.dob);
               $('#present_addr').val(row.present_addr);
               $('#permanent_addr').val(row.permanent_addr);
               $('#phone').val(row.phone);
               $('#email').val(row.email);
               $('#uploaded_image').attr('src',src);
            
               $('.tcr_inputs').css({'background':'transparent','border':'none'}).attr('disabled',true);
               $('#EditTcrSpinner').empty();
            },
            'click .ViewPhoto': function (e, value, row, index) {
               var tcr = row['full_name'];
               if(row['photo'] == null){
                  var src = '/public/uploads/common/photo_blank.png';
               }else{
                  var src = '/public/uploads/{{ $prefix }}/teachers/'+row.photo;
               }
               $('#ViewPhoto').attr('src',src);
               $('#TeacherName').text(tcr);
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
               .replace('%FATHER%', row.father)
               .replace('%MOTHER%', row.mother)
               .replace('%PREADDR%', row.present_addr)
               .replace('%PHONE%', row.phone)
               .replace('%PHOTO%', row.photo);
            })

            return `<div class="row mx-0">${view}</div>`;
         }
         
         function initTable() {
         $TeacherTable.bootstrapTable('destroy').bootstrapTable({
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
               field: 'idn',
               title: 'ID Number',
               sortable: true,
               align: 'center'
               },{
               field: 'full_name',
               title: 'Name',
               sortable: true,
               align: 'center'
               },{
               field: 'father',
               title: 'Father',
               sortable: true,
               align: 'center',
               },{
               field: 'mother',
               title: 'Mother',
               sortable: true,
               align: 'center',
               },{
               field: 'gender',
               title: 'Gender',
               sortable: true,
               align: 'center',
               },{
               field: 'dob',
               title: 'Date of Birth',
               sortable: true,
               align: 'center',
               },{
               field: 'present_addr',
               title: 'Present Address',
               sortable: true,
               align: 'center',
               },{
               field: 'phone',
               title: 'Phone',
               sortable: true,
               align: 'center',
               }
            ]
         })
         $TeacherTable.on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table',
         function () {
            $DeleteTeacher.prop('disabled', !$TeacherTable.bootstrapTable('getSelections').length)
         
            // save your data, here just save the current page
            selections = getIdSelections()
            // push or splice the selections if you want to save all data selections
         })
         $TeacherTable.on('all.bs.table', function (e, name, args) {
            //
         })
         }

         $DeleteTeacher.click(function () {
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
                  data: {_token:'{{ csrf_token() }}',table:'teachers', col:'id', ids:''+ids+''},
                  success: function(result){
                  if(result == true){
                     Swal.fire(
                        'Deleted!',
                        'success',
                        'success'
                     );
                     $TeacherTable.bootstrapTable('remove', {
                        field: 'id',
                        values: ids
                     });
                     $DeleteTeacher.prop('disabled', true)
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
         
         $(function() {
         initTable()
         
         $('#locale').change(initTable)
         })
      </script>

      <!-- Modal Table Profile View -->
      <div class="modal fade" id="ModalTeacherProfile" data-keyboard="false" data-backdrop="static">
         <div style="max-width: 600px" class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modal-title text-center">Profile View <button id="edit" style="width: 75px;font-size: 17px;border-radius:25px;"><i class="fa fa-edit"></i> Edit</button></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <form id="EditionFrom" action="" onSubmit="return false" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="id" id="id" required>
                     <input type="hidden" name="PreviousPhoto" id="PreviousPhoto">
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
                                                      <button type="button" id="crop" class="btn btn-primary">Save</button>
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
                                                      var id = $('#id').val();
                                                      $.ajax({
                                                         url:'{{ route("ChangePhoto") }}',
                                                         method:'POST',
                                                         data:{_token:'{{ csrf_token() }}',table:'teachers',col:'photo',id:id,image:base64data},
                                                         success:function(data){
                                                            $modal.modal('hide');
                                                            $('#uploaded_image').attr('src', '/public/uploads/{{ $prefix }}/teachers/'+data);
                                                            $('#TeacherTable').bootstrapTable('refresh');
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
                              <td><input type="text" name="full_name" id="full_name" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Father :</th>
                              <td><input type="text" name="father" id="father" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Mother :</th>
                              <td><input type="text" name="mother" id="mother" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Gender :</th>
                              <td>
                                 <select name="gender" id="gender" class="custom-select tcr_inputs @error('gender') is-invalid @enderror">
                                    <option value="">Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                 </select>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">Date of Birth :</th>
                              <td><input type="date" name="dob" id="dob" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Present Address :</th>
                              <td><input type="text" name="present_addr" id="present_addr" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Permanent Address :</th>
                              <td><input type="text" name="permanent_addr" id="permanent_addr" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Phone Number :</th>
                              <td><input type="number" name="phone" id="phone" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value=this.value.replace(/[^0-9]/g,'');" class="form-control tcr_inputs"></td>
                           </tr>
                           <tr>
                              <th scope="row">Email :</th>
                              <td><input type="email" name="email" id="email" class="form-control tcr_inputs"></td>
                           </tr>
                        </tbody>
                     </table>
               </div>
               <div class="modal-footer">
               <div id="editMessage" class="font-weight-bold"></div>
               <div id="EditTcrSpinner" style="width:35px;height:35px;display:none;">
                  @include('includes.spinner')
               </div>
               <input type="submit" class="btn btn-primary tcr_inputs" value="Save Changes">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
               </div>
               </form>
            </div>
         </div>
         <script>
            $('#edit').click(function(){
            $('#editPhoto').show();
            $('.tcr_inputs').css({'background':'','border':''}).attr('disabled',false);
            $('#full_name').focus();
            });
            $("#EditionFrom").on('submit',(function(e) {
            e.preventDefault();
            $("#editMessage").empty();
            $('#EditTcrSpinner').show();
            $.ajax({
               url: "{{ route('UpdateTeacher') }}",
               type: 'POST',
               data: new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
               success: function(result)
               {
                  $("#editMessage").html(result);
                  $('#TeacherTable').bootstrapTable('refresh');
                  $('#EditTcrSpinner').hide();
               }
            });
            }));
         </script>
      </div>
      <!-- Modal Table row photo view -->
      <div class="modal fade" id="ModalTeacherPhoto" data-keyboard="false" data-backdrop="static">
         <div style="max-width: 400px" class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 id="TeacherName" class="modal-title text-center">Teacher Name</h4>
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

      <!-- Modal Add Teacher -->
      <div class="modal fade" id="ModalAddTeacher" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <h4 class="modal-title text-center">New Teacher</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form id="SaveTeacher" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
               <!-- Modal body -->
               <div class="modal-body">
                  <div style="max-width: 500px; margin:auto;" class="card card-info">
                     <div class="card-body">
                        @csrf
                        <div class="form-group">
                           <label for="full_name">Full Name</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" placeholder="full name" required>
                              @error('full_name')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="full_name">Gender</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="gender" id="gender" class="custom-select @error('gender') is-invalid @enderror" required>
                                 <option value="">Select...</option>
                                 <option value="Male" @if(old('gender') == 'Male') selected @endif>Male</option>
                                 <option value="Female" @if(old('gender') == 'Female') selected @endif>Female</option>
                                 <option value="Others" @if(old('gender') == 'Others') selected @endif>Others</option>
                              </select>
                              @error('gender')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="dob">Date of birth</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                              </div>
                              <input type="date" name="dob" id="dob" value="{{ old('dob') }}" class="form-control @error('dob') is-invalid @enderror" required>
                              @error('dob')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="father">Father's Name</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <input type="text" name="father" id="father" value="{{ old('father') }}" class="form-control @error('father') is-invalid @enderror" placeholder="father's name" required>
                              @error('father')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="mother">Mother's Name</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <input type="text" name="mother" id="mother" value="{{ old('mother') }}" class="form-control @error('mother') is-invalid @enderror" placeholder="mother's name" required>
                              @error('mother')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="present_addr">Present Address</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                              </div>
                              <input type="text" name="present_addr" id="present_addr" value="{{ old('present_addr') }}" class="form-control @error('present_addr') is-invalid @enderror" placeholder="present address">
                              @error('present_addr')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="permanent_addr">Permanent Address</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                              </div>
                              <input type="text" name="permanent_addr" id="permanent_addr" value="{{ old('permanent_addr') }}" class="form-control @error('permanent_addr') is-invalid @enderror" placeholder="permanent address">
                              @error('permanent_addr')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="phone">Phone Number</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-phone"></i></span>
                              </div>
                              <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="phone number"  maxlength="11" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" required>
                              @error('phone')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="email">Email Address</label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                              </div>
                              <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email address">
                              @error('email')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="photo">Add Photo</label>
                           <div class="input-group mb-3">
                              <input class="w-100" type="file" name="photo" id="photo" />
                              <div class="w-100"><img style="width:150px; height:170px;" id="photo_preview" src="/public/assets/img/add-user.png" /></div>
                              <span style="position: absolute;top: 50%;left: 33px;" class="text-danger" id="photo_msg"></span>
                              @error('photo')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <div id="AddTcrMsg"></div>
                  <div id="AddTcrSpinner" style="width:35px;height:35px;display:none;">
                     @include('includes.spinner')
                  </div>
                  <button type="submit" class="btn btn-info pl-4 pr-4" data-dismiss="modal">Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
               </div>
            </form>
         </div>
      </div>

      <script>
         $("#SaveTeacher").on('submit',(function(e){
            e.preventDefault();
            $("#AddTcrMsg").empty();
            $('#AddTcrSpinner').show();
            $.ajax({
               url: "{{ route('SaveTeacher') }}",
               type: 'POST',
               data: new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
               success: function(result)
               {
                  $("#AddTcrMsg").html(result);
                  $('#AddTcrSpinner').hide();
               }
            });
         }));
      </script>
   </div>
</div>
@endsection