@extends('layouts.iframe')
@section('content')
@if(Auth::user()->who == 1)
<div id="toolbar">
  <h3 style="width:175px" class="text-center text-primary">Refers</h3>
  <form class="mb-0 m-2">
    <input type="text" name="user_id" value="" placeholder="user id">
    <input type="submit" value="GO">
  </form>
</div>
@endif
<table
   id="RefersInstTable"
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
   data-url="{{ route('RefersInstJson') }}"
   data-response-handler="responseHandler">
</table>
<script>
   var $RefersInstTable = $('#RefersInstTable')
   var selections = []
   
    function getIdSelections() {
     return $.map($RefersInstTable.bootstrapTable('getSelections'), function (row) {
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
        var status = row.completed;
        if(status == 1){
            var s = '';
        }else{
            var s = 'mSwitch-off';
        }
        return [
            '<div style="margin-bottom: -4px;" class="mSwitch-container d-inline-block"><div id="switch'+row.id+'" class="mSwitch '+s+'"><span class="mSwitch-button mSwitch-on-part">ON</span><span class="mSwitch-button"></span><span class="mSwitch-button mSwitch-off-part">OFF</span></div><input type="hidden" id="input'+row.id+'" value="'+status+'"></div>'
        ].join('')
    }

    window.operateEvents = {
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
                  url: "{{ route('InstReferActive') }}",
                  type: 'post',
                  data: {_token:'{{ csrf_token() }}', id:row.id, user_id:row.user_id},
                  success: function(result){
                     if(result == true){
                        $RefersInstTable.bootstrapTable('refresh');
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
     $RefersInstTable.bootstrapTable('destroy').bootstrapTable({
       columns:
       [
            {
            field: 'name',
            title: 'Name',
            align: 'center'
            },{
            field: 'user_id',
            title: 'User ID',
            align: 'center'
            },{
            field: 'balance',
            title: 'Balance',
            align: 'center'
            },{
            field: 'prefix',
            title: 'Prefix',
            align: 'center'
            },{
            field: 'package',
            title: 'Package',
            align: 'center'
            },{
            field: 'valid_months',
            title: 'Validation Months',
            align: 'center'
            },{
            field: 'created_at',
            title: 'Refer Time',
            align: 'center'
            },{
            field: 'operate',
            title: 'Activation',
            align: 'center',
            clickToSelect: false,
            events: window.operateEvents,
            formatter: operateFormatter
            }
        ]
     })
   }
   
    $(function() {
        initTable()
    })
</script>
@endsection