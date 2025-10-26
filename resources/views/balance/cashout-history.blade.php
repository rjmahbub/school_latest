@extends('layouts.iframe')
@section('title','Withdraw Request')
@section('content')
<div class="card ml-2 mb-0">
   <ul id="iframeMenu" class="p-0 m-0">
      <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
         <ul id="iframeNavigation" class="mb-0">
               <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
               <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
               <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
         </ul>
      </div>
      <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">APPS ACCOUNT</div>
      @if(Auth::user()->who == 1)
      <li><a href="{{ route('cashInFormSuperAdmin') }}">Cash-In</a></li>
      <li><a href="{{ route('SendMoneyForm') }}">Send Money</a></li>
      <li><a class="active">Withdraw Request</a></li>
      @endif
      @if(Auth::user()->who == 7)
      <li><a class="active">Cashout History</a></li>
      @endif
      <li><a href="{{ route('statement') }}">Statement</a></li>
   </ul>
   <div class="card-body">
      <div id="toolbar">
         <h3 class="text-center text-primary">Withdraw History</h3>
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
            data-url="{{ route('CashoutHistoryJson') }}"
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
               if(row.status == 'Paid'){
                  var s = '';
               }else{
                  var s = 'mSwitch-off';
               }
               return [
               '<div style="margin-bottom: -4px;" class="mSwitch-container d-inline-block"><div id="switch'+row.id+'" class="mSwitch '+s+'"><span class="mSwitch-button mSwitch-on-part">ON</span><span class="mSwitch-button"></span><span class="mSwitch-button mSwitch-off-part">OFF</span></div><input type="hidden" id="input'+row.id+'" value="'+row.status+'"></div>',
               '<a class="mx-3" href="{{ route("profile") }}?user_id='+row.user_id+'" title="User Profile"><i class="fa fa-user"></i></a>',
               '<a href="{{ route("statement") }}?user_id='+row.user_id+'" title="statement"><i class="fa fa-list"></i></a>'
               ].join('')
            }

            window.operateEvents = {
               'click .mSwitch': function(e, value, row, index){
                  var this_input = $('#input'+row.id);
                  var this_switch = $('#switch'+row.id);
                  this_switch.children().css('opacity',0.7);
                  if(this_input.val()=='Paid'){
                     var sv = 'Unpaid';
                  }else{
                     var sv = 'Paid';
                  }

                  Swal.fire({
                  title: 'Are you sure to '+sv,
                  text: '',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: ''+sv+''
                  }).then((result) => {
                     if (result.isConfirmed) {
                        $.ajax({
                           url: "{{ route('PaidStatusChange') }}",
                           type: 'post',
                           data: {_token:'{{ csrf_token() }}', id:row.id, status:''+sv+''},
                           success: function(result){
                              if(result == true){
                                 $CashoutHistoryTable.bootstrapTable('refresh');
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

            function statusFormatter(value, row, index) {
               if(row.status == 'Paid'){
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
                     title: 'Status | Profile | STMT',
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
                     },{
                     field: 'paid_at',
                     title: 'Paid Time',
                     align: 'center'
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
                     field: 'amount',
                     title: 'Amount',
                     align: 'center'
                     },{
                     field: 'method',
                     title: 'Withdraw Method',
                     align: 'center'
                     },{
                     field: 'cashout_to',
                     title: 'Mobile Banking',
                     align: 'center'
                     }
               ]
            })
            }
            
            $(function() {
               initTable()
            })
         </script>
   </div>
</div>
@endsection