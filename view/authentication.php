<?php require_once '../scafold/core.php'; ?>
<?php require_once '../scafold/header.php';?>
<?php $_SESSION['redirect'] = true; ?>

		<script>
            var oauth_url = 'https://www.facebook.com/dialog/oauth/';
            oauth_url += '?client_id=<?php echo $appId; ?>';
            oauth_url += '&redirect_uri=' + encodeURIComponent('https://www.facebook.com/<?php echo $page;?>?sk=app_<?php echo $appId; ?>');
            oauth_url += '&scope=email,user_birthday'
            window.top.location = oauth_url;
        </script>

 </head>
    <body>
   </body>
</html>

