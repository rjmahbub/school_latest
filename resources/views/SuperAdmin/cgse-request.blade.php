@extends('layouts.iframe')
@section('title','CGSE Request')
@section('content')
<style>
   .table td, .table th {
   padding: .15rem;
   }
</style>
<div id="toolbar">
    <button id="DeleteItem" class="btn btn-danger mt-1" disabled><i class="fa fa-trash"></i> Delete</button>
    <button id="approveItem" class="btn btn-success mt-1" disabled><i class="fa fa-check"></i> Approve</button>
</div>
<table
   id="cgseTable"
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
   data-url="{{ route('cgseJson') }}"
   data-response-handler="responseHandler"></table>
<script>
   var $cgseTable = $('#cgseTable')
   var $selectionItem = $('#DeleteItem,#approveItem')
   var selections = []
   
   function getIdSelections() {
     return $.map($cgseTable.bootstrapTable('getSelections'), function (row) {
       return row.id
     })
   }
   
   function responseHandler(res) {
     $.each(res.rows, function (i, row) {
       row.state = $.inArray(row.id, selections) !== -1
     })
     return res
   }
   
   function operateFormatter(value, row, index) {
   return [
      '<a style="font-size:17px;" class="AdminProfile mx-2" href="{{ route("userList") }}?code='+row.code+'" title="Institute Admin">','<i class="fa fa-user"></i>','</a> ',
      '<a style="font-size:17px;" class="delete text-danger" href="javascript:void(0)" title="Delete">','<i class="fa fa-trash"></i>','</a> '
   ].join('')
   }
   
   window.operateEvents = {
      'click .delete': function(e, value, row, index){
         /* var instName = row.inst_name;
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
                  $cgseTable.bootstrapTable('remove', {
                     field: 'inst_id',
                     values: ids
                  });
                  $selectionItem.prop('disabled', true)
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
         }) */
      }
   }

    $('#approveItem').click(function(){
        var ids = getIdSelections();
        Swal.fire({
        title: 'Are you sure to Approve',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Approve'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('approveCGSE') }}",
                    type: 'post',
                    data: {_token:'{{ csrf_token() }}', ids:''+ids+''},
                    success: function(result){
                        if(result == true){
                        $cgseTable.bootstrapTable('refresh');
                        }else{
                            Swal.fire(
                                'Some Error!',
                                '',
                                'error'
                            )
                        }
                    },
                    error: function(e){
                        Swal.fire(
                        'Error!',
                        '',
                        'error'
                        )
                    }
                })
            }
        });
      })
   
   function initTable() {
     $cgseTable.bootstrapTable('destroy').bootstrapTable({
       columns:
       [
         {
           field: 'state',
           checkbox: 'true',
           align: 'center'
         },{
           field: 'operate',
           title: 'Item Actions',
           align: 'center',
           clickToSelect: false,
           events: window.operateEvents,
           formatter: operateFormatter
         },{
           field: 'prefix',
           title: 'Prefix',
           sortable: true,
           align: 'center',
         },{
           field: 'phone',
           title: 'Phone',
           sortable: true,
           align: 'center',
         },{
           field: 'request_item',
           title: 'Request Item',
           sortable: true,
           align: 'center',
         },{
           field: 'name',
           title: 'Name',
           sortable: true,
           align: 'center',
         }
       ]
     })
     $cgseTable.on('check.bs.table uncheck.bs.table ' +
       'check-all.bs.table uncheck-all.bs.table',
     function () {
       $selectionItem.prop('disabled', !$cgseTable.bootstrapTable('getSelections').length)
       selections = getIdSelections()
     })
     $cgseTable.on('all.bs.table', function (e, name, args) {
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