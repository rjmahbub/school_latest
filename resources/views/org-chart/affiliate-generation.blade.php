<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Generation</title>
  <link rel="stylesheet" href="/public/assets/plugins/org-chart/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="/public/assets/plugins/org-chart/css/jquery.jOrgChart.css"/>
  <link rel="stylesheet" href="/public/assets/plugins/org-chart/css/custom.css"/>
  <link href="/public/assets/plugins/org-chart/css/prettify.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
  <script type="text/javascript" src="/public/assets/plugins/org-chart/js/prettify.js"></script>
  <!-- jQuery includes -->
  <script type="text/javascript" src="/public/assets/plugins/org-chart/js/jquery.min.js"></script>
  <script type="text/javascript" src="/public/assets/plugins/org-chart/js/jquery-ui.min.js"></script>
  <script src="/public/assets/plugins/org-chart/js/jquery.jOrgChart.js"></script>
  <script>
    jQuery(document).ready(function() {
      $("#org").jOrgChart({
        chartElement : '#chart',
        dragAndDrop  : true
      });
    });
  </script>
</head>
<body onload="prettyPrint();" style="padding:0px;">
@if($request->style == 1 || !$request->style)
<style>
  .gen-img{height: 83%;}
  .jOrgChart .node {
    width: 100px;
    height: 115px;
    border-radius: 7px;
    -moz-border-radius: 7px;
  }
</style>
@else
<style>
  .name{display:none;}
</style>
@endif
<div style="margin:20px;">
  @if(Auth::user()->who == 1)
  <form action="">
    <div class="input-group">
      <input type="number" class="form-control" value="{{ $request->phone }}" placeholder="phone" name="phone">
      <input type="hidden" name="style" value="{{ $request->style }}">
      <input type="hidden" name="level" value="{{ $request->level }}">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">GO</button>
      </span>
    </div>
  </form>
  @endif

  @if($tree == false)
  <h4>No Generation Found!</h4>
  @else
  <div>
    <h3><i class="fa fa-sitemap"></i> Your Down-link</h3>
    <label for="style1"><input type="radio" onclick="changeRadio(this.value)" name="style" id="style1" value="1" @if($request->style == 1 || !$request->style) checked @endif> Style 1</label>
    <label for="style2"><input type="radio" onclick="changeRadio(this.value)" name="style" id="style2" value="2" @if($request->style == 2) checked @endif> Style 2</label>
  </div>
  <ul id="org" style="display:none">
  <?php
      function olLiTree( $tree ) {
          foreach ( $tree as $parent ) {
            if($parent['img'] == null){
                $photo = 'blank-user.png';
            }else{
                $photo = $parent['img'];
            }
            echo "<li><div class='name'>".$parent['name']."</div><img class='gen-img' src='/public/uploads/users/".$photo."' alt='".$parent['name']."'/>";
            if ( isset($parent['child']) ) {
                echo '<ul>';
                olLiTree( $parent['child'] );
                echo '</ul>';
            }
            echo "</li>";
          }
      }
      olLiTree($tree);
  ?>
  </ul>
  @endif
  <div id="chart" class="orgChart"></div>
  <?php $level = $request->level ? : 5; ?>
  <a class="btn" href="?phone={{ $request->phone }}&style={{ $request->style }}&level={{ $level + 5 }}">Load More</a>
</div>
<script>
  function changeRadio(v){
    window.open('/affiliate-generation?phone={{ $request->phone }}&style='+v+'&level={{ $level }}','_self')
  }
</script>
</body>
</html>