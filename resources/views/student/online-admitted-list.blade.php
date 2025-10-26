@extends('layouts.iframe')
@section('title','Online Admission')
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
      <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">STUDENT</div>
      <li><a href="{{ route('ClassList') }}?student">Classwise Students</a></li>
      <li><a class="active">None Approval</a></li>
  </ul>
  <div class="card-body">
    <div id="toolbar">
      <button id="DeleteStudent" class="btn btn-danger mt-1" disabled><i class="fa fa-trash"></i> Delete</button>
      <button id="Approved" data-toggle="modal" data-target="#ModalApprove" class="btn btn-success mt-1" disabled><i class="fa fa-trash"></i> Approve</button>
    </div>
    <table
      id="StudentTable"
      data-toolbar="#toolbar"
      data-search="true"
      data-show-refresh="true"
      data-show-columns="true"
      data-show-columns-toggle-all="true"
      data-show-export="true"
      data-export-types="['doc','excel','pdf']"
      data-click-to-select="true"
      data-minimum-count-columns="2"
      data-pagination="true"
      data-side-pagination="server"
      data-id-field="id"
      data-page-list="[10, 25, 50, 100, 150, all]"
      data-show-print="true"
      data-url="{{ route('onlineAdmissionJson') }}"
      data-response-handler="responseHandler">
    </table>
    <script>
      var $StudentTable = $('#StudentTable')
      var $DeleteStudent = $('#DeleteStudent')
      var $Approved = $('#Approved')
      var $SelectToEnable = $('#DeleteStudent,#Approved')
      var selections = []
      
        function getIdSelections() {
        return $.map($StudentTable.bootstrapTable('getSelections'), function (row) {
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
          '<a style="margin: 0 3px 0 3px; font-size:25px;" class="viewProfile" href="" title="View Profile">','<i class="fa fa-file"></i>','</a> '
          ].join('')
      }
      
      function PhotoFormat(value, row, index) {
          if(row.photo == null){
            var photo_link = '/public/assets/img/dashboard/blank-user.png';
          }else{
            var photo_link = '/public/uploads/{{ $prefix }}/students/'+row.photo;
          }
          return [
            '<a class="ViewPhoto" data-toggle="modal" data-target="#ModalStudentPhoto"><img style="width:60px" src="'+photo_link+'" alt="photo"></a>'
          ].join('')
      }
      
      window.operateEvents = {
        'click .viewProfile': function (e, value, row, index) {

          },
          'click .ViewPhoto': function (e, value, row, index) {
            var st = row['full_name'];
            if(row['photo'] == null){
                var src = '/public/assets/img/dashboard/blank-user.png';
            }else{
                var src = '/public/uploads/{{ $prefix }}/students/'+row['photo'];
            }
            $('#ViewPhoto').attr('src',src);
            $('#StudentName').text(st);
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
        $StudentTable.bootstrapTable('destroy').bootstrapTable({
          columns:
          [
            {
              field: 'state',
              checkbox: true,
              align: 'center',
              valign: 'middle'
            },{
              field: 'operate',
              title: 'Attached Files',
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
              field: 'class',
              title: 'Class',
              align: 'center'
            },{
              field: 'full_name',
              title: 'Name',
              align: 'center'
            },{
              field: 'father',
              title: 'Father',
              align: 'center',
            },{
              field: 'mother',
              title: 'Mother',
              align: 'center',
            },{
              field: 'gender',
              title: 'Gender',
              align: 'center',
            },{
              field: 'dob',
              title: 'Date of Birth',
              align: 'center',
            },{
              field: 'present_addr',
              title: 'Present Address',
              align: 'center',
            },{
              field: 'phone',
              title: 'Phone',
              align: 'center',
            }
          ]
        })
        $StudentTable.on('check.bs.table uncheck.bs.table ' +
          'check-all.bs.table uncheck-all.bs.table',
        function () {
          $SelectToEnable.prop('disabled', !$StudentTable.bootstrapTable('getSelections').length)
          selections = getIdSelections()
        })
        $StudentTable.on('all.bs.table', function (e, name, args) {
          console.log(name, args)
        })
      }

        $DeleteStudent.click(function () {
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
                data: {_token:'{{ csrf_token() }}',table:'online_admitted', col:'id', ids:''+ids+''},
                success: function(result){
                if(result == true){
                  Swal.fire(
                      'Deleted!',
                      'success',
                      'success'
                  );
                  $StudentTable.bootstrapTable('remove', {
                      field: 'id',
                      values: ids
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

        
        $Approved.click(function () {
          $('#ids').val('');
          ids = getIdSelections()
          $('#ids').val(ids)
        })

      $(function() {
        initTable()
      
        $('#locale').change(initTable)
      })
    </script>

    <!-- Modal Online admission approve form -->
    <div class="modal fade" id="ModalApprove" data-keyboard="false" data-backdrop="static">
      <div style="max-width: 400px" class="modal-dialog">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title text-center">Admission Approve</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body text-center">
                <form action="{{ route('AdmissionApprove') }}" method="POST" class="mt-4">
                  @csrf
                  <input type="hidden" name="ids" id="ids" required>
                  <input type="text" name="session" placeholder="session" required>
                  <input type="submit" value="Approve">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection