@extends('layouts.iframe')
@section('title','MCQ Question')
@section('content')
<div class="row">
    <?php 
        $i = 1;
        if($request->opt == 1){
            $a = array(1=>'(a) ', 2=>'(b) ', 3=>'(c) ', 4=>'(d) ');
        }else{
            $a = array(1=>'(ক) ', 2=>'(খ) ', 3=>'(গ) ', 4=>'(ঘ) ');
        }

        $qno = count($questions);
        $d = 2;
    ?>
    @foreach($questions as $question)
    @if($i == 1 || $i == $d)
    <div class="col-6">
    @endif
    
        <b>{{ $i.'. '.$question->qname }}</b>
        <p class="ml-4 mb-0">{{ $a[1].$question->opt1 }} {{ $a[2].$question->opt2 }} {{ $a[3].$question->opt3 }} {{ $a[4].$question->opt4 }}</p>
        <?php $i++; ?>
    @if($i == 1 || $i == $d)
    </div>
    @endif
    
    @endforeach
</div>
<div class="ans">
    <?php $i = 1; ?>
    <p class="ml-4 mb-0">
    @foreach($questions as $question)
    {{ $i.$a[$question->ans] }},
    <?php $i++; ?>
    @endforeach
    </p>
</div>
@endsection