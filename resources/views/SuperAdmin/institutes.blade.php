@extends('layouts.iframe')
@section('content')
@section('title','Institute List')
<style>
   .table td, .table th {
   padding: .15rem;
   }
</style>
<div id="toolbar"></div>
<table
   id="InstituteTable"
   data-toolbar="#toolbar"
   data-search="true"
   data-show-refresh="true"
   data-show-fullscreen="true"
   data-show-columns="true"
   data-show-columns-toggle-all="true"
   data-minimum-count-columns="2"
   data-show-export="true"
   data-click-to-select="true"
   data-export-types="['doc','excel','pdf']"
   data-pagination="true"
   data-page-list="[10, 25, 50, 100, 150, all]"
   data-side-pagination="server"
   data-show-print="true"
   data-url="{{ route('InstitutesJson') }}"
   data-response-handler="responseHandler"></table>
<script>
   var $InstituteTable = $('#InstituteTable')
   var $DeleteInstitute = $('#DeleteInstitute')
   var selections = []
   
   function getIdSelections() {
     return $.map($InstituteTable.bootstrapTable('getSelections'), function (row) {
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
      var status = row.status;
      if(status == 1){
         var s = '';
      }else{
         var s = 'mSwitch-off';
      }
   return [
      '<div style="margin-bottom: -4px;" class="mSwitch-container d-inline-block"><div id="switch'+row.id+'" class="mSwitch '+s+'"><span class="mSwitch-button mSwitch-on-part">ON</span><span class="mSwitch-button"></span><span class="mSwitch-button mSwitch-off-part">OFF</span></div><input type="hidden" id="input'+row.id+'" value="'+status+'"></div>',
      '<a style="font-size:17px;" class="AdminProfile mx-2" href="{{ route("userList") }}?code='+row.code+'" title="Institute Admin">','<i class="fa fa-user"></i>','</a> ',
      '<a style="font-size:17px;" class="delete text-danger" href="javascript:void(0)" title="Delete">','<i class="fa fa-trash"></i>','</a> '
   ].join('')
   }

   function switchFormatter(value, row, index) {
      if(row.status == 1){
         var s = 'success';
         var st = 'Active';
      }else{
         var s = 'danger';
         var st = 'Inactive';
      }
      return [
         '<button class="btn btn-sm btn-'+s+'">'+st+'</button>'
      ].join('')
   }

   function PhotoFormat(value, row, index) {
      if(row.photo == null){
         var photo_link = '/public/uploads/common/inst_logo.png';
      }else{
         var photo_link = '/public/uploads/{{ $prefix }}/others/'+row.photo;
      }
     return [
       '<a class="ViewPhoto" data-toggle="modal" data-target="#ModalInstitutePhoto"><img style="width:60px" src="'+photo_link+'" alt="photo"></a>'
     ].join('')
   }
   
   window.operateEvents = {
      'click .ViewPhoto': function (e, value, row, index) {
         var inst_name = row.inst_name;
         if(row.photo == null){
            var src = '/public/uploads/common/inst_logo.png';
         }else{
            var src = '/public/uploads/{{ $prefix }}/others/'+row.photo;
         }
         $('#ViewPhoto').attr('src',src);
         $('#InstituteName').text(inst_name);
      },
      'click .delete': function(e, value, row, index){
         var instName = row.inst_name;
         Swal.fire({
         title: 'Enter Password',
         html: '<from><label>to delete</label><br><label>'+instName+'</label><input class="form-control font-big pwd" type="text" id="password" placeholder="enter password"></form>',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#d33',
         cancelButtonColor: '#3085d6',
         confirmButtonText: 'Delete'
         }).then((result) => {
         if (result.isConfirmed) {
            var ids = getIdSelections();
            $.ajax({
               url: "",
               type: 'post',
               data: {_token:'{{ csrf_token() }}',tbl:'inst_infos',ids:ids},
               success: function(result){
               if(result == true){
                  Swal.fire(
                     'Deleted!',
                     'success',
                     'success'
                  );
                  $InstituteTable.bootstrapTable('remove', {
                     field: 'inst_id',
                     values: ids
                  });
                  $DeleteInstitute.prop('disabled', true)
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
      },
      'click .mSwitch': function(e, value, row, index){
         var this_input = $('#input'+row.id);
         var this_switch = $('#switch'+row.id);
         this_switch.children().css('opacity',0.7);
         if(this_input.val()==1){
            var tx = 'Inactive';
            var sv = 0;
         }else{
            var tx = 'Active';
            var sv = 1;
         }

         Swal.fire({
         title: 'Are you sure to '+tx,
         text: '',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#d33',
         cancelButtonColor: '#3085d6',
         confirmButtonText: ''+tx+''
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  url: "{{ route('oneColUpdate') }}",
                  type: 'post',
                  data: {_token:'{{ csrf_token() }}', table:'inst_infos', whereCol:'id', whereVal:row.id, upCol:'status', upVal:sv},
                  success: function(result){
                     if(result == true){
                        $InstituteTable.bootstrapTable('refresh');
                     }else{
                        Swal.fire(
                           'Some Error!',
                           '',
                           'error'
                        );
                        this_switch.children().css('opacity',1);
                     }
                  },
                  error: function(e){
                     Swal.fire(
                        'Error!',
                        '',
                        'error'
                     );
                  }
               })
            }else{
               this_switch.children().css('opacity',1);
            }
         });
      }
   }
   
   function initTable() {
     $InstituteTable.bootstrapTable('destroy').bootstrapTable({
       columns:
       [
         @if(Auth::user()->who == 1)
         {
           field: 'operate',
           title: 'Item Actions',
           align: 'center',
           clickToSelect: false,
           events: window.operateEvents,
           formatter: operateFormatter
         },
         @endif
         {
           field: 'id',
           title: 'ID',
           sortable: true,
           align: 'center',
         },{
           field: 'valid_till',
           title: 'Valid Till',
           sortable: true,
           align: 'center',
         },{
           field: 'code',
           title: 'Code',
           sortable: true,
           align: 'center',
         },{
           field: 'logo',
           title: 'Logo',
           align: 'center',
           clickToSelect: false,
           events: window.operateEvents,
           formatter: PhotoFormat
         },{
           field: 'prefix',
           title: 'Prefix',
           sortable: true,
           align: 'center',
         },{
           field: 'inst_name',
           title: 'Institute Name',
           sortable: true,
           align: 'center',
         },{
           field: 'inst_addr',
           title: 'Address',
           sortable: true,
           align: 'center',
         }
         @if(Auth::user()->who == 7)
         ,{
           field: 'operate',
           title: 'Active',
           align: 'center',
           clickToSelect: false,
           formatter: switchFormatter
         }
         @endif
         @if(Auth::user()->who == 1)
         ,{
           field: 'inst_phone',
           title: 'Phone',
           sortable: true,
           align: 'center',
         },{
           field: 'inst_phone2',
           title: 'Phone Alt',
           sortable: true,
           align: 'center',
         },{
           field: 'inst_email',
           title: 'Email',
           sortable: true,
           align: 'center',
         }
         @endif
       ]
     })
     $InstituteTable.on('check.bs.table uncheck.bs.table ' +
       'check-all.bs.table uncheck-all.bs.table',
     function () {
       $DeleteInstitute.prop('disabled', !$InstituteTable.bootstrapTable('getSelections').length)
   
       // save your data, here just save the current page
       selections = getIdSelections()
       // push or splice the selections if you want to save all data selections
     })
     $InstituteTable.on('all.bs.table', function (e, name, args) {
       console.log(name, args)
     })
   }

   $(function() {
     initTable()
   
     $('#locale').change(initTable)
   })
</script>
<!-- Modal Table row photo view -->
<div class="modal fade" id="ModalInstitutePhoto" data-keyboard="false" data-backdrop="static">
   <div style="max-width: 400px" class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 id="InstituteName" class="modal-title text-center">Institute Name</h4>
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
@if(Auth::user()->who == 1)
<script>
   $("#SaveInstitute").on('submit',(function(e) {
      e.preventDefault();
      $("#AddTcrMsg").empty();
      $('#AddTcrSpinner').show();
      $.ajax({
         url: "{{ route('DomainRegister') }}",
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
@endif
@endsection