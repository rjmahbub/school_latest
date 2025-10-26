// set the first nav item as active
  var dis = $(".list-wrap li").eq(0);

  // align the wave
  align(dis);

  // align the wave on click
  $(".list-wrap li").click(function(){
    dis = $(this);
    
    align(dis);
  });

  function align(dis){
    
    // get index of item
    var index = dis.index() + 1;
    
    // add active class to the new item
    $(".list-wrap li").removeClass("active");
    dis.delay(100).queue(function() {
      dis.addClass('active').dequeue();
    });
    
    // move the wave
    var liw = $(".list-wrap li").width();
    var a = liw - 150;
    var b = a/2 + 5;

    var left = index * liw - liw + b;
    
    $("#wave").css('left', left);
    
    //var color = dis.data('color');
    //$("body").css('background', color);
    
    // set the text
    $(".page").text(dis.attr("title"));
  }