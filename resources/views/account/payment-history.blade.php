@extends('layouts.iframe')
@section('content')
<div id="toolbar">
<h3 class="text-center text-primary">Cash-In History</h3>
</div>

<table
   id="CashoutHistoryTable"
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
   data-url="{{ route('PaymentHistoryJson') }}"
   data-response-handler="responseHandler">
</table>
<script>
   var $CashoutHistoryTable = $('#CashoutHistoryTable')
   var selections = []
   
   function getIdSelections() {
     return $.map($CashoutHistoryTable.bootstrapTable('getSelections'), function (row) {
       return row.member_id
     })
   }
   
   function responseHandler(res) {
     $.each(res.rows, function (i, row) {
       row.state = $.inArray(row.member_id, selections) !== -1
     })
     return res
   }

   window.operateEvents = {
     'click .viewProfile': function (e, value, row, index) {
        //
    }
   }
   
    function operateFormatter(value, row, index) {
      return [
         '<button style="margin-bottom:2px;" class="btn btn-xs btn-success approve">Approve</button>',
         '<a class="mx-3" href="{{ route("profile") }}?user_id='+row.user_id+'" title="User Profile"><i class="fa fa-user"></i></a>',
         '<a href="{{ route("statement") }}?user_id='+row.user_id+'" title="statement"><i class="fa fa-list"></i></a>'
      ].join('')
    }

    window.operateEvents = {
      'click .approve': function(e, value, row, index){
         if(row.status == 'Approved'){
            Swal.fire(
                'Already Approved!',
                '',
                'success'
            );
            return false;
         }
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
                  url: "{{ route('PaymentApprove') }}",
                  type: 'post',
                  data: {_token:'{{ csrf_token() }}', id:row.id, user_id:row.user_id},
                  success: function(result){
                     if(result == true){
                        $CashoutHistoryTable.bootstrapTable('refresh');
                     }else{
                        Swal.fire(
                           'Some Error!',
                           '',
                           'error'
                        );
                     }
                  },
                  error: function(e){
                    Swal.fire(
                        'Syntax Error!',
                        '',
                        'error'
                    );
                  }
               })
            }
         });
      }
    }

    function statusFormatter(value, row, index) {
        if(row.status == 'Approved'){
            var color = 'green';
        }else{
            var color = 'red';
        }
        return [
            '<span style="color:'+color+';font-weight:bold">'+row.status+'</span>'
        ].join('')
    }
   
   function initTable() {
     $CashoutHistoryTable.bootstrapTable('destroy').bootstrapTable({
       columns:
       [
            @if(Auth::user()->who == 1)
            {
            field: 'operate',
            title: 'Approve | Profile | STMT',
            align: 'center',
            clickToSelect: false,
            events: window.operateEvents,
            formatter: operateFormatter
            },
            @endif
            {
            field: 'status',
            title: 'Status',
            align: 'center',
            formatter: statusFormatter
            },
            {
            field: 'created_at',
            title: 'Transaction Time',
            align: 'center'
            },{
            field: 'user_id',
            title: 'User ID',
            align: 'center'
            },{
            field: 'balance',
            title: 'Current Balance',
            align: 'center'
            },{
            field: 'method',
            title: 'Payment Method',
            align: 'center'
            },{
            field: 'amount',
            title: 'Amount',
            align: 'center'
            },{
            field: 'payer_number',
            title: 'Payer Number',
            align: 'center'
            },{
            field: 'tnx',
            title: 'TNX ID',
            align: 'center'
            }
       ]
     })
   }
   
    $(function() {
        initTable()
    })
</script>
@endsection