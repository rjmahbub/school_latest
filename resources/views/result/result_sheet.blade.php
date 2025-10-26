@extends('layouts.iframe')
@section('title','Result Sheet')
@section('content')
<style>
   .table td, .table th {padding: .15rem;}
</style>
<div class="text-center">
    <h4>{{ $inst->inst_name }}</h4>
    <h6>Class Name : {{ $class_name }} @if($group_name !== '')| Group : {{ $group_name }} @endif</h6>
    <p class="mb-0">{{ $exam_name }} Exam ({{ $month }} {{ $request->year }})</p>
</div>
@auth()
@if(Auth::user()->who == 3)
<div id="toolbar">
   <button id="DeleteResult" class="btn btn-danger mt-1" disabled><i class="fa fa-trash"></i> Delete</button>
   <button id="ResultFilter" class="btn btn-primary mt-1" data-toggle="modal" data-target="#ModalResultFilter"><i class="fa fa-filter"></i> Filter</button>
</div>
@endif
@endauth
<table
   id="ResultTable"
   data-toolbar="#toolbar"
   data-search="true"
   data-show-refresh="true"
   data-show-columns="true"
   data-show-columns-toggle-all="true"
   data-show-export="true"
   data-export-types="['doc','excel','pdf']"
   data-click-to-select="true"
   data-minimum-count-columns="2"
   data-id-field="id"
   data-page-list="[10, 25, 50, 100, 150, all]"
   data-show-print="true"
   data-url="{{ route('ResultSheetJson') }}?year={{ $request->year }}&month={{ $request->month }}&exam_id={{ $request->exam_id }}&class_id={{ $request->class_id }}&grp_id={{ $request->grp_id }}"
   data-response-handler="responseHandler">
</table>
<script>
   var $ResultTable = $('#ResultTable')
   var $DeleteResult = $('#DeleteResult')
   var $SelectToEnable = $('#DeleteResult,#GeneratePaper')
   var selections = []
   
   function getIdSelections() {
     return $.map($ResultTable.bootstrapTable('getSelections'), function (row) {
       return row.roll
     })
   }
   
   function responseHandler(res) {
     $.each(res.rows, function (i, row) {
       row.state = $.inArray(row.roll, selections) !== -1
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
      '<a style="margin: 0 3px 0 3px; font-size:20px;" class="edit" data-toggle="modal" data-target="#ModalEdit" href="javascript:void(0)" title="View Profile">','<i class="fa fa-edit"></i>','</a> '
      ].join('')
    }

    window.operateEvents = {
        'click .edit': function (e, value, row, index) {
            $('#full_name,#roll').val('');
            $('#full_name').val(row.name);
            $('#roll').val(row.roll);
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
   
   function initTable() {
     $ResultTable.bootstrapTable('destroy').bootstrapTable({
        columns:[
          @auth()
            @if(Auth::user()->who == 3)
            {
            field: 'state',
            checkbox: true,
            align: 'center',
            valign: 'middle'
            },
            @endif
          @endauth
            {
            field: 'roll',
            title: 'Roll',
            align: 'center'
            },{
            field: 'name',
            title: 'Name'
            }
            @foreach($subArr as $sub)
                ,{
                field: '{{ $sub->sub_name }}',
                title: '{{ $sub->sub_name }}',
                align: 'center'
                }
            @endforeach
          @auth()
            @if(Auth::user()->who == 2)
            ,{
            field: 'operate',
            title: 'Actions',
            align: 'center',
            clickToSelect: false,
            events: window.operateEvents,
            formatter: operateFormatter
            }
            @endif
          @endauth
        ]
     })
     $ResultTable.on('check.bs.table uncheck.bs.table ' +
       'check-all.bs.table uncheck-all.bs.table',
     function () {
       $SelectToEnable.prop('disabled', !$ResultTable.bootstrapTable('getSelections').length)
       // save your data, here just save the current page
       selections = getIdSelections()
       // push or splice the selections if you want to save all data selections
     })
     $ResultTable.on('all.bs.table', function (e, name, args) {
       console.log(name, args)
     })
   }
   @auth()
   @if(Auth::user()->who == 2)
    $DeleteResult.click(function () {
      Swal.fire({
      title: 'Are you sure to delete selections?',
      text: '',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
      }).then((result) => {
      if (result.isConfirmed) {
         var rolls = getIdSelections();
        $.ajax({
            url: "{{ route('DeleteResults') }}",
            type: 'POST',
            data: {_token:'{{ csrf_token() }}', rolls:''+rolls+'', class_id:{{ $request->class_id }}, grp_id:{{ $request->grp_id }}, exam_id:{{ $request->exam_id }}, @if($request->month) month:'{{ $request->month }}',@endif year:{{ $request->year }} },
            success: function(result){
            if(result == true){
               Swal.fire(
                  'Deleted!',
                  'success',
                  'success'
               );
               $ResultTable.bootstrapTable('remove', {
                  field: 'roll',
                  values: rolls
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
    @endif
    @endauth
   
   $(function() {
     initTable()
   
     $('#locale').change(initTable)
   })
</script>
@auth()
  @if(Auth::user()->who == 2)
<!-- Modal result edit -->
<div class="modal fade" id="ModalEdit" data-keyboard="false" data-backdrop="static">
   <div style="max-width: 400px" class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 id="StudentName" class="modal-title text-center">Result Edit</h4>
            <button type="button" onclick="location.reload()" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <form id="UpdateResult" action="{{ route('ResultUpdate') }}" method="post">
            @csrf
         <div class="modal-body">
            <div class="form-group">
                <label for="full_name">Student Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i style="font-size:20px;" class="fa fa-user-graduate"></i></span>
                    </div>
                    <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" disabled>
                    @error('full_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="roll">Roll Number</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i style="font-size:20px;" class="fa fa-user-graduate"></i></span>
                    </div>
                    <input type="number" name="roll" id="roll" class="form-control @error('roll') is-invalid @enderror">
                    @error('roll')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="sub_id">Subject</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i style="font-size:20px;" class="fas fa-book"></i></span>
                    </div>
                    <select name="sub_id" class="custom-select @error('sub_id') is-invalid @enderror" required>
                    <option value=''>Select Subject</option>
                    @foreach($subArr as $sub)
                    <option value="{{ $sub->sub_id }}">{{ $sub->sub_name }}</option>
                    @endforeach
                    </select>
                    @error('sub_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="marks">Marks</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i style="font-size:20px;" class="fa fa-book"></i></span>
                    </div>
                    <input type="number" name="marks" id="marks" class="form-control @error('marks') is-invalid @enderror">
                    @error('marks')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="class_id" value="{{ $request->class_id }}">
            <input type="hidden" name="grp_id" value="{{ $request->grp_id }}">
            <input type="hidden" name="exam_id" value="{{ $request->exam_id }}">
            <input type="hidden" name="month" value="{{ $request->month }}">
            <input type="hidden" name="year" value="{{ $request->year }}">
         </div>
         <div class="modal-footer">
            <div id="message"></div>
            <div style="width:30px;height:30px;display:none;" id="spinner">@include('includes.spinner')</div>
            <button type="submit" class="btn btn-success">Update</button>
            <button type="button" class="btn btn-secondary" onclick="location.reload()" data-dismiss="modal">Close</button>
         </div>
         </form>
         <script>
            $("#UpdateResult").on('submit',(function(e) {
                e.preventDefault();
                $("#message").empty();
                $('#spinner').show();
                $.ajax({
                    url: "{{ route('ResultUpdate') }}",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(result){
                        if(result == true){
                            $('#spinner').hide();
                            $("#message").html('<i class="fa fa-check text-success"> Change Saved!</i>');
                        }else{
                            $('#spinner').hide();
                            $("#message").html('<i class="fa fa-times-circle text-danger"> Nothing Changed!</i>');
                        }
                    },
                    error: function(e){
                        $('#spinner').hide();
                        $("#message").html('<i class="fa fa-times-circle text-danger"> Nothing Changed!</i>');
                    }
                });
            }));
         </script>
      </div>
   </div>
</div>
  @endif
@endauth
@endsection