@extends('layouts.iframe')
@section('title','Payment List')
@section('content')
<style>
   .table td, .table th {
   padding: .15rem;
   }
</style>
<div id="toolbar"></div>
<table
   id="PaymentsTable"
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
   data-url="{{ route('paymentJson') }}"
   data-response-handler="responseHandler"></table>
<script>
   var $PaymentsTable = $('#PaymentsTable')
   var $DeletePayment = $('#DeletePayment')
   var selections = []
   
   function getIdSelections() {
     return $.map($PaymentsTable.bootstrapTable('getSelections'), function (row) {
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
            '<a href="javascript:void(0)" class="sendSms" ><i style="font-size:25px;" class="fa fa-envelope"></i></a>'
        ].join('')
    }
   
    window.operateEvents = {
        'click .sendSms': function (e, value, row, index) {
            if(row.ref_no == null){
                var number = row.sender;
            }else{
                var number = row.ref_no;
            }
            Swal.fire({
                title: 'Send SMS with Token',
                text: ''+number+'',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Send !'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('ajaxSmsSend') }}",
                        type: 'post',
                        data: {_token:'{{ csrf_token() }}', numbers:''+number+'', message:'Your recharge token number '+row.token+''},
                        success: function(result){
                            if(result == true){
                                Swal.fire(
                                    'Message Sent!',
                                    'success',
                                    'success'
                                );
                            }else{
                                Swal.fire(
                                    'Sending Failed!',
                                    '',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        }
    }
   
   function initTable() {
     $PaymentsTable.bootstrapTable('destroy').bootstrapTable({
       columns:
       [
         {
           field: 'operate',
           title: 'Item Actions',
           align: 'center',
           clickToSelect: false,
           events: window.operateEvents,
           formatter: operateFormatter
         },{
           field: 'method',
           title: 'Method',
           sortable: true,
           align: 'center',
         },{
           field: 'sender',
           title: 'Sender Number',
           sortable: true,
           align: 'center',
         },{
            field: 'ref_no',
           title: 'Ref. Number',
           sortable: true,
           align: 'center',
         },{
           field: 'tnx_id',
           title: 'Tnx ID',
           sortable: true,
           align: 'center',
         },{
           field: 'amount',
           title: 'Amount',
           sortable: true,
           align: 'center',
         }
         @if(Auth::user()->who == 1)
         ,{
           field: 'token',
           title: 'Token',
           sortable: true,
           align: 'center',
         }
         @endif
         ,{
           field: 'recharge_by',
           title: 'Recharge by User',
           sortable: true,
           align: 'center',
         }
       ]
     })
     $PaymentsTable.on('check.bs.table uncheck.bs.table ' +
       'check-all.bs.table uncheck-all.bs.table',
     function () {
       $DeletePayment.prop('disabled', !$PaymentsTable.bootstrapTable('getSelections').length)
       selections = getIdSelections()
     })
     $PaymentsTable.on('all.bs.table', function (e, name, args) {
       console.log(name, args)
     })
   }

   $(function() {
     initTable()
   
     $('#locale').change(initTable)
   })
</script>
@endsection