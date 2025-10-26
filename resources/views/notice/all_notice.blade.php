@extends('layouts.iframe')
@section('title','All Notice')
@section('content')
<?php
    if(isset($_GET['q'])){
        $q = $_GET['q'];
    }else{
        $q = ' ';
    }
?>
<div class="card ml-2">
    <ul id="iframeMenu" class="p-0 m-0">
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
            <ul id="iframeNavigation" class="mb-0">
                <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
            </ul>
        </div>
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title"><i class="fas fa-bell text-secondary"></i> NOTICE</div>
        <li><a class="active">All Notice</a></li>
        <li><a href="{{ route('AddNoticeForm') }}">Add Notice</a></li>
    </ul>
    <div class="card" style="background:#f4f6f9;">
      <style>
         .table td, .table th {
         padding: .15rem;
         }
      </style>
      <div id="toolbar">
         <a href="{{ route('AddNotice') }}"><button id="AddNotice" class="btn btn-success"><i class="fa fa-plus"></i> Notice</button></a>
         <select id="q" style="padding-top:0;margin-left:5px;width:135px;display:initial;" class="form-control" onchange="if (this.value) window.location.href='?q='+this.value">
            <option value=" " {{ $q == ' ' ? 'selected' : '' }}>All Notice</option>
            <option value="1" {{ $q == '1' ? 'selected' : '' }}>Exam</option>
            <option value="2" {{ $q == '2' ? 'selected' : '' }}>Headline</option>
         </select>
      </div>
      <table
         id="NoticeTable"
         data-toolbar="#toolbar"
         data-search="true"
         data-show-refresh="true"
         data-show-toggle="true"
         data-show-fullscreen="true"
         data-show-columns="true"
         data-show-columns-toggle-all="true"
         data-show-export="true"
         data-export-types="['doc','excel','pdf']"
         data-click-to-select="true"
         data-minimum-count-columns="2"
         data-pagination="true"
         data-id-field="id"
         data-page-list="[10, 25, 50, 100, 150, all]"
         data-show-print="true"
         data-side-pagination="server"
         data-url="{{ route('NoticesJson') }}?q={{ $q }}"
         data-response-handler="responseHandler">
      </table>
      <script>
         var $NoticeTable = $('#NoticeTable')
         var $DeleteNotice = $('#DeleteNotice')
         var selections = []
         
         function getIdSelections() {
         return $.map($NoticeTable.bootstrapTable('getSelections'), function (row) {
            return row.inst_id
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
               var s = 'switchOn';
               var cb = 'true';
            }else{
               var s = '';
               var cb = 'false';
            }
         return [
         '<a style="font-size:23px;" class="delete ml-1 text-danger" href="javascript:void(0)" title="Delete">','<i class="fa fa-trash"></i>','</a> ',
         '<a style="font-size:23px;" class="edit ml-1 text-primary" href="{{ route("AddNoticeForm") }}?id='+row.id+'" title="Edit">','<i class="fa fa-edit"></i>','</a> '
         ].join('')
         }
         
         function SwitchExam(value, row, index) {
         if(row.exam == 'on'){
            var s = 'switchOn';
         }else{
            var s = '';
         }
         return [
            '<label title="On/Off" class="mb-0"><div style="display:inherit;margin:-5px;" class="mx-1 ExamSwitch switch '+s+'"></div></label>'
         ].join('')
         }

         function SwitchHeadline(value, row, index) {
         if(row.headline == 'on'){
            var s = 'switchOn';
         }else{
            var s = '';
         }
         return [
            '<label title="On/Off" class="mb-0"><div style="display:inherit;margin:-5px;" class="mx-1 HeadlineSwitch switch '+s+'"></div></label>'
         ].join('')
         }
         
         window.operateEvents = {
            'click .delete': function (e, value, row, index) {
               var id = row.id;
               Swal.fire({
               title: 'Are you sure to Delete?',
               text: 'warning: you can not recover deleted item!',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, Delete'
               }).then((result) => {
                  if (result.isConfirmed) {
                     $.ajax({
                        url: "{{ route('DeleteByIds') }}",
                        type: 'post',
                        data: {_token:'{{ csrf_token() }}', table:'notices', col:'id', ids:id},
                        success: function(result){
                           if(result == true){
                              $NoticeTable.bootstrapTable('refresh');
                           }else{
                              Swal.fire(
                                 'Failed!',
                                 '',
                                 'error'
                              );
                           }
                        },
                        error: function(e){
                           Swal.fire(
                              'Error!',
                              '',
                              'error'
                           );
                        }
                     });
                  }
               });
            },
            'click .ExamSwitch': function(e, value, row, index){
               var id = row.id;
               if(row.exam == 'on'){
                  var tx = 'Yes, Off';
                  var cs = '';
               }else{
                  var tx = 'Yes, On';
                  var cs = 'on';
               }

               Swal.fire({
               title: 'Are you sure to Change?',
               text: '',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: ''+tx+''
               }).then((result) => {
                  if (result.isConfirmed) {
                     $.ajax({
                        url: "{{ route('UpdateById') }}",
                        type: 'post',
                        data: {_token:'{{ csrf_token() }}', table:'notices', id_col:'id', id:id, update_col:'exam', value:cs},
                        success: function(result){
                           if(result == true){
                              $NoticeTable.bootstrapTable('refresh');
                           }else{
                              Swal.fire(
                                 'Failed!',
                                 '',
                                 'error'
                              );
                           }
                        },
                        error: function(e){
                           Swal.fire(
                              'Error!',
                              '',
                              'error'
                           );
                        }
                     });
                  }
               });
            },
            'click .HeadlineSwitch': function(e, value, row, index){
               var id = row.id;
               if(row.headline == 'on'){
                  var tx = 'Yes, Off';
                  var cs = '';
               }else{
                  var tx = 'Yes, On';
                  var cs = 'on';
               }

               Swal.fire({
               title: 'Are you sure to Change?',
               text: '',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: ''+tx+''
               }).then((result) => {
                  if (result.isConfirmed) {
                     $.ajax({
                        url: "{{ route('UpdateById') }}",
                        type: 'post',
                        data: {_token:'{{ csrf_token() }}', table:'notices', id_col:'id', id:id, update_col:'headline', value:cs},
                        success: function(result){
                           if(result == true){
                              $NoticeTable.bootstrapTable('refresh');
                           }else{
                              Swal.fire(
                                 'Failed!',
                                 '',
                                 'error'
                              );
                           }
                        },
                        error: function(e){
                           Swal.fire(
                              'Error!',
                              '',
                              'error'
                           );
                        }
                     });
                  }
               });
            }
         }
         
         function initTable() {
         $NoticeTable.bootstrapTable('destroy').bootstrapTable({
            locale: $('#locale').val(),
            columns:
            [
               {
               field: 'sl',
               title: 'SL',
               align: 'center',
               },{
               field: 'title',
               title: 'Title',
               align: 'left',
               },{
               field: 'description',
               title: 'Description',
               align: 'left',
               },{
               field: 'exam',
               title: 'Exam Notice',
               align: 'center',
               events: window.operateEvents,
               formatter: SwitchExam
               },{
               field: 'headline',
               title: 'Headline',
               align: 'center',
               events: window.operateEvents,
               formatter: SwitchHeadline
               },{
               field: 'operate',
               title: 'Actions',
               align: 'center',
               clickToSelect: false,
               events: window.operateEvents,
               formatter: operateFormatter
               }
            ]
         })
         $NoticeTable.on('check.bs.table uncheck.bs.table' +
            'check-all.bs.table uncheck-all.bs.table',
         function () {
            $DeleteNotice.prop('disabled', !$NoticeTable.bootstrapTable('getSelections').length)
            selections = getIdSelections()
         })
         $NoticeTable.on('all.bs.table', function (e, name, args) {
            console.log(name, args)
         })
         }

         $(function() {
         initTable()
         
         $('#locale').change(initTable)
         })
      </script>
   </div>
</div>
@endsection