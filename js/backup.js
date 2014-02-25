$(document).ready(function() {

	$('.btn-971').click(function(){
		$('#departement').val('Guadeloupe');
	});
	
	$('.btn-972').click(function(){
		$('#departement').val('Martinique');
	});

	
	/*
	function delayAnimation() {
		setTimeout(function() {
		startAnimation('box1');
		}, 0);
		setTimeout(function() {
		startAnimation('box2');
		}, 4000);
		setTimeout(function() {
		startAnimation('box3');
		}, 8000);
		setTimeout(function() {
		startAnimation('box4');
		}, 12000);
		setTimeout(function() {
		startAnimation('box5');
		}, 16000);
	}


	function startAnimation(box){
		  var arc_params = {
    center: [300,900],  
        radius: 700,    
        start: -120,
        end: -110
  }	  
  $('#'+box).animate(
	    {
	      path : new $.path.arc(arc_params),
	      
	    }, 3000, function(){startAnimation(box)}
	  );
	  
	}
	
	delayAnimation();
	
	
	function stopAnimation(){
		$('.box').stop();
	}
	
	 
	//setTimeout(stopAnimation, 6000);
	
	*/
	/*
	$('.backgroundCarousel').svg();
	
	var curve = new CurveAnimator(
	  [-111,272], [494,299],
	  [32,142], [305,138]
	);

	var o = document.getElementById('test');
	o.style.position = 'absolute';
	
	curve.animate(20, function(point,angle){
	  o.style.left = point.x+"px";
	  o.style.top  = point.y+"px";
	  o.style.transform =
	    o.style.webkitTransform =
	    o.style.MozTransform =
	    "rotate("+angle+"deg)";
	});
	*/
	
	
	function startBallThree(name) {
        $("#"+name).circulate({
            speed: 10000,
            height: 300,
            width: 1800,
            loop: true,
            zIndexValues: [1, -1, -1, 1]
        });
    }
   /*         
    setTimeout(function(){startBallThree('test');}, 1000);
    setTimeout(function(){startBallThree('test1');}, 2000);
    setTimeout(function(){startBallThree('test2');}, 3000);
    setTimeout(function(){startBallThree('test3');}, 4000);
    setTimeout(function(){startBallThree('test4');}, 5000);
    setTimeout(function(){startBallThree('test5');}, 6000);
    setTimeout(function(){startBallThree('test6');}, 7000);
    setTimeout(function(){startBallThree('test7');}, 8000);
    setTimeout(function(){startBallThree('test8');}, 9000);
    */
    var tl = new TimelineMax({repeat:-1});
    var photo = document.getElementById("test"); //or use jQuery's $("#photo")
    //tl.add( TweenLite.to(photo, 4, {left:"1440px", directionalRotation:"40_cw"}) );
    //tl.add( TweenMax.to(photo, 3, {bezier:[{x:250, y:0}, {x:500, y:0}]}) );
    tl.add( TweenMax.to(photo, 5, {bezier:{curviness:1.25, values:[{x:0, y:0},{x:475, y:-50},{x:950, y:0}], autoRotate:true}} ));
    
    alert('lol');
   $('#myModal').on('hidden.bs.modal', function () {
	   window.alert('hidden event fired!');
   })    /*
    $('.launch-video').click(function(){
	  autoPlayVideo('WGtBz4rZaa8','450','283');
	});
	
	function autoPlayVideo(vcode, width, height){
	  "use strict";
	  $("#videoContainer").html('<iframe width="'+width+'" height="'+height+'" src="https://www.youtube.com/embed/'+vcode+'?&autoplay=1&rel=0&fs=0&showinfo=0&modestbranding=1&controls=0&hd=1&color=white" frameborder="0" allowfullscreen wmode="Opaque"></iframe>');
	}
	*/
	
	

	
	  
});
