@extends('layouts.site')
@section('content')
@section('title','Home')
<section class="slideshow">
    <div class="row">
        <aside class="col-md-12 px-0">
            <div id="carousel1_indicator" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php $i = 0 ?>
                    @foreach($images as $image)
                    <li data-target="#carousel1_indicator @if($i==0) active @endif" data-slide-to="{{ $i }}"></li>
                    <?php $i++; ?>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    <?php $i = 1 ?>
                    @foreach($images as $image)
                    <div class="carousel-item @if($i==1) active @endif"><img class="d-block w-100" src="/public/uploads/{{ $prefix }}/slideshow/{{ $image->img }}" alt="slide no {{ $i }}"></div>
                    <?php $i++; ?>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div> 
        </aside>
    </div>
</section>
<section class="main_body">
    <div class="row">
        <div class="col-12 p-0" style="background: radial-gradient(#29b347, transparent);height:40px;">
            <div style="position: absolute;padding:8px 20px;top:0;background: #e00000;color: #fff;border-radius: 3px;text-align: center;z-index: 11111;">শিরোনাম</div>
            <style>
                ul#headline{display:flex;}
                ul#headline>a{margin-left:15px;color:#010038;}
                ul#headline>a>li{list-style:none;}
                ul>a{color:#010038;}
            </style>
            <marquee onmouseover="this.stop()" onmouseout="this.start()">
                <ul id="headline" class="mb-0 pt-2">
                    @foreach($headlines as $headline)
                    <a href="{{ route('ViewNotice') }}?ni={{ $headline->id }}"><li><i class="fa fa-pen-nib"></i> {{ $headline->title }}</li></a>
                    @endforeach
                </ul>
            </marquee>
        </div>
        <div class="col-12 pt-5">
            <div class="card">
                <h4 class="card-header text-center">Notice Board</h4>
                <div class="card-body px-1 px-lg-4 px-md-2">
                    <?php
                        if(isset($_GET['q'])){
                            $q = $_GET['q'];
                        }else{
                            $q = ' ';
                        }
                    ?>
                    <table
                        id="NoticeTable"
                        data-search="true"
                        data-show-refresh="true"
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
                        
                        window.operateEvents = {
                            'click .edit': function (e, value, row, index) {
                                //
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
                                width: 50,
                                },{
                                field: 'created_at',
                                title: 'Date',
                                align: 'center',
                                width: 180,
                                },{
                                field: 'title',
                                title: 'Notice Title',
                                align: 'left',
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
        </div>
    </div>
</section>
<section class="gallery-section table-success px-1" style="margin: -15px -15px;">   
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Photo Gallery</h2>
        </div>
        <div class="row">
            @foreach($photos as $photo)
            <div class="gallery-item col-lg-2 col-md-4 col-sm-6 col-6 wow fadeIn">
                <div class="image-box">
                    <figure class="image"><img src="/public/uploads/{{ $prefix }}/photo_gallery/{{ $photo->img }}" alt="{{ $photo->img }}"></figure>
                    <div class="overlay-box"><a href="/public/uploads/{{ $prefix }}/photo_gallery/{{ $photo->img }}" class="lightbox-image" data-fancybox='gallery'><span class="icon fa fa-expand-arrows-alt"></span></a></div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!--Styled Pagination-->
        <ul class="styled-pagination text-center">
            @for($i=1;$i<=$page;$i++)
            <li><a href="?pgp={{ $i }}" @if($request->pgp == $i) class="active" @endif @if(!$request->pgp && $i == 1) class="active" @endif>{{ $i }}</a></li>
            @endfor
            <li><a href="#"><span class="icon fa fa-angle-right"></span></a></li>
        </ul>
        <!--End Styled Pagination-->
    </div>
</section>
<section id="documentation" class="news-section">
    <div class="anim-icons"> <span class="icon icon-circle-blue wow fadeIn"></span> <span class="icon twist-line-1 wow zoomIn"></span> <span class="icon twist-line-2 wow zoomIn"></span> <span class="icon twist-line-3 wow zoomIn"></span> </div>
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Video Gallery</h2>
        </div>
        <div class="row">
            @foreach($videos as $video)
            <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="400ms">
                <div class="inner-box">
                    <figure class="image">
                        <a href="blog-single.html"><img src="/public/uploads/{{ $prefix }}/video_gallery/{{ $video->img }}"></a>
                        <a href="{{ $video->link }}" class="play-now play_btn" data-fancybox="gallery" data-caption=""><i class="icon flaticon-play-button-3" aria-hidden="true"></i><span class="ripple"></span></a>
                    </figure>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection