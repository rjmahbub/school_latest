@extends('layouts.iframe')
@section('title','All User')
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
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">USER & PERMISSION</div>
        <li><a class="active">User List</a></li>
        <li><a href="{{ route('UserPermission') }}">Permission</a></li>
    </ul>
    <div class="card-body">
        <style>
            .table td, .table th {padding: .15rem;}
        </style>
        <div id="toolbar">
            <button id="DeleteTeacher" class="btn btn-danger mb-1" disabled><i class="fa fa-trash"></i> Delete</button>
            <select style="width:initial;display:initial;" class="form-control" name="user" onchange="window.location.href='?user='+this.value">
                <option value="">All User</option>
                <option value="4" @if($request->user == 4) selected @endif>Teacher</option>
                <option value="5" @if($request->user == 5) selected @endif>Student</option>
                <option value="6" @if($request->user == 6) selected @endif>Guardian</option>
            </select>
        </div>
        <table
            id="TeacherTable"
            data-toolbar="#toolbar"
            data-search="true"
            data-show-refresh="true"
            data-show-custom-view="true"
            data-custom-view="customViewFormatter"
            data-show-custom-view-button="true"
            data-show-export="true"
            data-click-to-select="true"
            data-export-types="['doc','excel','pdf']"
            data-pagination="true"
            data-page-list="[10, 25, 50, 100, 150, all]"
            data-side-pagination="server"
            data-url="{{ route('UsersJson') }}?user={{ $request->user }}"
            data-response-handler="responseHandler">
        </table>
        <template id="profileTemplate">    
            <div class="col-sm-8 col-md-6 col-lg-4">
                <div class="profile-card card rounded-lg shadow p-4 p-xl-5 mb-4 text-center position-relative overflow-hidden">
                    <div class="banner"></div>
                    <img width="190" src="/public/uploads/{{ $prefix }}/users/%PHOTO%" onerror="this.src='/public/uploads/common/blank-user.png'" class="img-circle mx-auto mb-3">
                    <h3 class="mb-4">%NAME%</h3>
                    <div class="text-left mb-4">
                        <p class="mb-2"><i class="fa fa-envelope mr-2"></i> %EMAIL%</p>
                        <p class="mb-2"><i class="fa fa-phone mr-2"></i>+880 %PHONE%</p>
                    </div>
                    <!-- <div class="social-links d-flex justify-content-center">
                        <a href="%INSTA%" class="mx-2"><img src="/public/assets/img/icons/dribbble.svg" alt="Dribbble"></a>
                        <a href="%FB%" class="mx-2"><img src="/public/assets/img/icons/facebook.svg" alt="Facebook"></a>
                        <a href="%LINKDIN%" class="mx-2"><img src="/public/assets/img/icons/linkedin.svg" alt="Linkedin"></a>
                        <a href="%YT%" class="mx-2"><img src="/public/assets/img/icons/youtube.svg" alt="Youtube"></a>
                    </div> -->
                </div>
            </div>
        </template>
        <script>
        var $TeacherTable = $('#TeacherTable')
        var $DeleteTeacher = $('#DeleteTeacher')
        var selections = []
        
        function getIdSelections() {
            return $.map($TeacherTable.bootstrapTable('getSelections'), function (row) {
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
        '<a style="margin: 0 3px 0 3px; font-size:35px;" class="viewProfile" data-toggle="modal" data-target="#ModalTeacherProfile" href="javascript:void(0)" title="View Profile">','<i class="fa fa-id-card"></i>','</a> '
        ].join('')
        }
        
        function PhotoFormat(value, row, index) {
            if(row.photo == null){
                var photo_link = '/public/uploads/common/blank-user.png';
            }else{
                var photo_link = '/public/uploads/{{ $prefix }}/teachers/'+row.photo;
            }
            return [
            '<a class="ViewPhoto" data-toggle="modal" data-target="#ModalTeacherPhoto"><img style="width:60px;margin:auto;" src="'+photo_link+'" alt="photo"></a>'
            ].join('')
        }
        
        window.operateEvents = {
            'click .viewProfile': function (e, value, row, index) {
                $('#id,#full_name,#father,#mother,#gender,#dob,#present_addr,#permanent_addr,#phone,#email').val('');
                if(row.photo == null){
                    src = '/public/assets/img/add-user.png';
                }else{
                    src = '/public/uploads/{{ $prefix }}/teachers/'+row.photo;
                }
                $('#id').val(row.id);
                $('#PreviousPhoto').val(row.photo);
                $('#full_name').val(row.full_name);
                $('#father').val(row.father);
                $('#mother').val(row.mother);
                $('#gender').val(row.gender);
                $('#dob').val(row.dob);
                $('#present_addr').val(row.present_addr);
                $('#permanent_addr').val(row.permanent_addr);
                $('#phone').val(row.phone);
                $('#email').val(row.email);
                $('#uploaded_image').attr('src',src);
            
                $('.tcr_inputs').css({'background':'transparent','border':'none'}).attr('disabled',true);
                $('#EditTcrSpinner').empty();
            },
            'click .ViewPhoto': function (e, value, row, index) {
                var tcr = row['full_name'];
                if(row['photo'] == null){
                    var src = '/public/uploads/common/photo_blank.png';
                }else{
                    var src = '/public/uploads/{{ $prefix }}/teachers/'+row.photo;
                }
                $('#ViewPhoto').attr('src',src);
                $('#TeacherName').text(tcr);
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

        function customViewFormatter (data) {
            var template = $('#profileTemplate').html()
            var view = '';
            $.each(data, function (i, row) {
                view += template.replace('%NAME%', row.nick_name)
                .replace('%PHONE%', row.phone)
                .replace('%EMAIL%', row.email)
                .replace('%PHOTO%', row.photo);
            })

            return `<div class="row mx-0">${view}</div>`;
        }
        
        function initTable() {
            $TeacherTable.bootstrapTable('destroy').bootstrapTable({
            columns:
            [
                {
                field: 'state',
                checkbox: true,
                align: 'center',
                valign: 'middle'
                },{
                field: 'operate',
                title: 'Actions',
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
                field: 'nick_name',
                title: 'Profile Name',
                align: 'center'
                },{
                field: 'gender',
                title: 'Gender',
                align: 'center',
                },{
                field: 'phone',
                title: 'Phone',
                align: 'center',
                }
            ]
            })
            $TeacherTable.on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table',
            function () {
            $DeleteTeacher.prop('disabled', !$TeacherTable.bootstrapTable('getSelections').length)
        
            // save your data, here just save the current page
            selections = getIdSelections()
            // push or splice the selections if you want to save all data selections
            })
            $TeacherTable.on('all.bs.table', function (e, name, args) {
            console.log(name, args)
            })
        }

        $DeleteTeacher.click(function () {
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
                    data: {_token:'{{ csrf_token() }}',table:'teachers', col:'id', ids:''+ids+''},
                    success: function(result){
                    if(result == true){
                    Swal.fire(
                        'Deleted!',
                        'success',
                        'success'
                    );
                    $TeacherTable.bootstrapTable('remove', {
                        field: 'id',
                        values: ids
                    });
                    $DeleteTeacher.prop('disabled', true)
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
        
        $(function() {
            initTable()
        
            $('#locale').change(initTable)
        })
        </script>
    </div>
</div>
@endsection