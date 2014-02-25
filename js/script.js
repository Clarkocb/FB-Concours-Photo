$(document).ready(function() {

	/************************ Img preloading  ***************************/
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
	}

	preload([
	    /*'../img/btn-push-hover.png',
	    '../img/bkg-video.jpg',
	    '../img/bkg-lightbox-base.png',
	    '../img/banner-yop.png',
	    '../img/bkg-caroussel.jpg',
	    '../img/bkg-form-inscription.png',
	    '../img/bkg-lightbox-base.png',
	    '../img/bkg-standard.jpg',
	    '../img/bkg-start.jpg'*/
	]);


	$('.btn-next').click(function(){

		pageBlock = $(this).parent().parent();
		$(pageBlock).hide();
		$(pageBlock).next().show();

		// console.log(pageBlock);
		// console.log($(pageBlock).next());
	});

	$('.btn-previous').click(function(){

		pageBlock = $(this).parent().parent();
		$(pageBlock).hide();
		$(pageBlock).prev().show();
	});


	/************************ Img preloading  ***************************/


	$('#send-form').click(function(){
		$('#form-inscription').submit();
	});

	$('#imgFile').change(function(){
     	$('#subfile').val($(this).val());
	});


	$('#imgFileAuto').change(function(){
     	$('.autoSend').submit();
	});

	$('#friend-invite').click(function(){
		FB.ui({method: 'apprequests',
		  message: 'Invite tes amis à voir ta photo de carnaval',
		  redirect_uri: 'https://www.facebook.com/pages/France-Antilles-Martinique/366618075391?id=366618075391&sk=app_1441284122774738',
		  data: 'test'
		}, requestCallback);
	});

	function requestCallback(response){
		console.log(response);
		// if(response!=""){
		// 	var ids = response["to"];
		//     for (var i = 0; i < ids.length; ++i)
		//     {
		//         //"ids[i]" is what you want.
		//     }
		// }
	}

	$('#wall-share').click(function(){

		FB.ui({
		  method: 'feed',
		  link: 'https://apps.facebook.com/faconcoursphoto',
		  name: 'Concours Photo France Antilles',
		  picture: 'https://facebook.beecee.fr/FAConcoursPhoto/img/200x200.png',
		  caption: 'Je viens de participer au concours photo organisé par France Antilles ! Viens voir mes photos et vote pour tes préférées',
		}, function(response){});
	});


});
