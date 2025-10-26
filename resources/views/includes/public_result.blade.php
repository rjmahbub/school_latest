<style>
    .fa-plus, .fa-minus{background: #8e8e8e;border-radius: 50%;padding: 3px;height: 18px;width: 18px;font-size: 11px;text-align: center;color:#fff;}
</style>
<div class="row p-md-3">
    <div class="col-lg-3">
        <ul id="tree1" class="tree">
            @foreach($array as $k => $v)
            <li class="branch"><i></i><a href="">{{ $array[$k]['class_name'] }}</a>
                <ul>
                    @if(isset($array[$k]['groups']))
                        @php $loop = count($array[$k]['groups']) -1; @endphp
                        @foreach($array[$k]['groups'] as $mk => $mv)
                            <li class="branch"><i></i><a href="">{{ $mv }}</a>
                                <ul>
                                    @if($exams)
                                        @foreach($exams as $exam)
                                        <li><a href="{{ route('PublicResultIframe') }}?class_id={{ $array[$k]['class_id'] }}&grp_id={{ $mk }}&exam_id={{ $exam['exam_id'] }}@if($exam['exam_name'] == 'Monthly')&month={{$exam['exam_id']}}@endif" target="results">{{ $exam['exam_name'] }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    @else
                    @if($exams)
                        @foreach($exams as $exam)
                        <li><a href="{{ route('PublicResultIframe') }}?class_id={{ $array[$k]['class_id'] }}&exam_id={{ $exam['exam_id'] }}@if($exam['exam_name'] == 'Monthly')&month={{$exam['exam_id']}}@endif" target="results">{{ $exam['exam_name'] }}</a></li>
                        @endforeach
                    @endif
                    @endif
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-lg-9">
        <iframe style="width:100%;height:500px;border:1px solid #d6d6d6;" name="results" id="results" frameborder="1" scrolling="yes" src="{{ route('PublicResultIframe') }}"></iframe>
    </div>
</div>
<script type="text/javascript">
    $.fn.extend({
        treed: function (o){
            var openedClass = 'fa fa-minus';
            var closedClass = 'fa fa-plus';
            
            if (typeof o != 'undefined'){
                if (typeof o.openedClass != 'undefined'){
                openedClass = o.openedClass;
                }
                if (typeof o.closedClass != 'undefined'){
                closedClass = o.closedClass;
                }
            };
            //initialize each of the top levels
            var tree = $(this);
            tree.addClass("tree");
            tree.find('li').has("ul").each(function () {
                var branch = $(this); //li with children ul
                branch.prepend("<i class='indicator " + closedClass + "'></i>");
                branch.addClass('branch');
                branch.on('click', function (e) {
                    if (this == e.target) {
                        var icon = $(this).children('i:first');
                        icon.toggleClass(openedClass + " " + closedClass);
                        $(this).children().children().toggle();
                    }
                })
                branch.children().children().toggle();
            });
            //fire event from the dynamically added icon
            tree.find('.branch .indicator').each(function(){
                $(this).on('click', function () {
                    $(this).closest('li').click();
                });
            });
            //fire event to open branch if the li contains an anchor instead of text
            tree.find('.branch>a').each(function () {
                $(this).on('click', function (e) {
                    $(this).closest('li').click();
                    e.preventDefault();
                });
            });
            //fire event to open branch if the li contains a button instead of text
            tree.find('.branch>button').each(function () {
                $(this).on('click', function (e) {
                    $(this).closest('li').click();
                    e.preventDefault();
                });
            });
        }
    });

    //Initialization of treeviews
    $('#tree1').treed();
    $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
    $('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});
</script>