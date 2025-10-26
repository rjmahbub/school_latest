@extends('layouts.iframe')
@section('title','Statement')
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
      @if(Auth::user()->who == 3)
      <li><a href="{{ route('payment') }}">Payment</a></li>
      <li><a href="{{ route('InstituteRenewForm') }}">Renew</a></li>
      @endif
      @if(Auth::user()->who == 1)
        <li><a href="{{ route('cashInFormSuperAdmin') }}">Cash-In</a></li>
        <li><a href="{{ route('SendMoneyForm') }}">Send Money</a></li>
        <li><a href="{{ route('cashoutHistory') }}">Withdraw Request</a></li>
      @endif
      @if(Auth::user()->who == 7)
        <li><a href="{{ route('cashoutForm') }}">Cashout</a></li>
      @endif
      <li><a class="active">Statement</a></li>
  </ul>
  <div class="card-body">
    <div id="toolbar">
      <h3 style="width:175px" class="text-center text-primary">Statements</h3>
      @if(Auth::user()->who == 1)
      <form class="mb-0 m-2">
        <input type="text" name="user_id" value="{{ $request->user_id }}" placeholder="user id">
        <input type="submit" value="GO">
      </form>
      @endif
    </div>
    <table
      id="StatementTable"
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
      data-url="{{ route('StatementJson') }}?user_id={{ $request->user_id }}"
      data-response-handler="responseHandler">
    </table>
    <script>
      var $StatementTable = $('#StatementTable')
      var selections = []
      
      function getIdSelections() {
        return $.map($StatementTable.bootstrapTable('getSelections'), function (row) {
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
            if(row.status == 'out'){
                var color = 'red';
            }else{
                var color = 'green';
            }
            return [
                '<span style="color:'+color+';font-weight:bold">'+row.status+'</span>'
            ].join('')
        }
      
      function initTable() {
        $StatementTable.bootstrapTable('destroy').bootstrapTable({
          columns:
          [
                @if(Auth::user()->who == 1 && $request->user_id)
                {
                field: 'user_id',
                title: 'User ID',
                align: 'center'
                },
                @endif
                {
                field: 'created_at',
                title: 'Transaction Time',
                align: 'center'
                },{
                field: 'transaction_amount',
                title: 'Transaction Amount',
                align: 'center'
                },{
                field: 'transaction_type',
                title: 'Type',
                align: 'center'
                },{
                field: 'balance_before',
                title: 'Balance Before Trans.',
                align: 'center'
                },{
                field: 'balance_now',
                title: 'Current Balance',
                align: 'center'
                },{
                field: 'status',
                title: 'Balance Info',
                align: 'center',
                formatter: operateFormatter
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