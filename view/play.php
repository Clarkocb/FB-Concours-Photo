<?php require_once '../scafold/core.php'; ?>
<?php require_once '../scafold/header.php'; ?>

<script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '<?php echo $appId; ?>', // App ID
            channelUrl : '//facebook.beecee.fr/jeuYop18Ans/view/channel.php',
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
            });
            //FB.Canvas.setSize({ width: 800, height: 675 });
            FB.Canvas.setSize({height:700});
			setTimeout(function(){
			FB.Canvas.setAutoGrow(1000);
			}, 710);			
            //FB.Canvas.setAutoGrow(91);
            // Additional initialization code here
        };
		// Load the SDK asynchronously
	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/all.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
</script>


<style>
	#box {
		position: absolute;
	}
	.test {

		position: absolute;
		bottom: 240px;
		margin-left: -110px;
		overflow-x: auto;
	}

	.box { left:720px
	}

	.container {
		overflow:hidden;
	}
</style>


        <div class="container backgroundCarousel">
            
            <div class="compteur">	
        		<div class="div-txt-compteur">
        			<img src="../img/txt-compteur.png" />
        		</div>
        		<div class="div-compteur">
        		</div>
            </div>
        	
        	<div class="bouteilles">
				<img id="test0" class="test" src="../img/bouteille/1-casquette.png" />
				<img id="test1" class="test" src="../img/bouteille/2-marin.png" />
				<img id="test2" class="test" src="../img/bouteille/3-melon.png" />
				<img id="test3" class="test" src="../img/bouteille/4-madras.png" />
				<img id="test4" class="test" src="../img/bouteille/5-bonnet.png" />
				<img id="test5" class="test" src="../img/bouteille/1-casquette.png" />
				<img id="test6" class="test" src="../img/bouteille/2-marin.png" />	
			</div>
        	
        	<div class="div-play-push">
        		<img id="push" src='../img/stop.png' />
        	</div>

        	<?php require_once('../scafold/menu-bottom.php'); ?>
	    </div><!-- Container --> 
        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>
 