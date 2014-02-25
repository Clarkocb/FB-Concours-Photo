<?php

if(!isset($_SESSION['user'])){
  $params = array(
  'scope' => 'email,user_birthday',
  'client_id' => $appId,
  'redirect_uri' => $fb_page['link'].'?sk=app_'.$appId
  );

  $loginUrl = $facebook->getLoginUrl($params);
}

 ?>

<!DOCTYPE html>
<html lang="fr"  >
    <head>
        <link href="../css/bootstrap.min.css" rel="stylesheet"  type="text/css" media="screen" >
        <link rel='stylesheet' type='text/css' href='../css/style.css?version=1.3' />
        <!-- <link href='https://fonts.googleapis.com/css?family=Lato:300,400,900,900italic' rel='stylesheet' type='text/css'> -->
        <link href="../css/admin.css" rel="stylesheet"  type="text/css" media="screen" >
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    		<script src="../js/bootstrap.min.js" ></script>

        <meta property="og:title" content="Concours Photo Desperados"/>
        <meta property="og:image" content="../img/128x128.png<?php echo rand(); ?>"/>


        <meta charset="utf-8" />
    </head>
  <script  src="../js/script.js"></script>


<?php if($id_GA!=""){ ?>
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $id_GA; ?>', 'facebook.com');
  ga('send', 'pageview');

</script>
<?php } ?>

  <body>

<script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '<?php echo $appId; ?>', // App ID
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true,  // parse XFBML
            frictionlessRequests : true
            });
      FB.Canvas.setSize({height:700});
      setTimeout(function(){
      FB.Canvas.setAutoGrow(1000);
      }, 1210);
            // Additional initialization code here
            FB.Event.subscribe('edge.create', function(href, widget) {

                widgetId = $(widget).attr('id');
                if(widgetId=="fangate-like"){
                  parent.location.href = "https://www.facebook.com/<?php echo $_SESSION['pageId']; ?>?sk=app_<?php echo $appId; ?>";
                }else{
                  //console.log(widgetId);
                  $.post( "ajax.php", { action: "vote", id: widgetId } );
                }
            });

            FB.Event.subscribe('edge.remove', function(href, widget) {
                imageId = $(widget).attr('id');
                $.post( "ajax.php", { action: "unvote", id: imageId } );
            });

        };
    // Load the SDK Asynchronously
    (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/fr_FR/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
     }(document));
</script>

    <div id="fb-root"></div>
