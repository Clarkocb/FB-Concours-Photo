<?php
session_start();
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
ob_start();

require_once('../../Facebook-Core/class/UserManager.php');
require_once('../../Facebook-Core/class/DocumentManager.php');
require_once('../../Facebook-Core/class/ApplicationManager.php');
require_once('../../Facebook-Core/facebook_function.php');

if(stripos($_SERVER['HTTP_REFERER'], "https://apps.facebook.com") !== false) {
    $javascript = "<script>
        /*window.top.location = 'https://www.facebook.com/".$_SESSION['pageId']."/app_".$appId."';*/
        window.top.location = 'https://www.facebook.com/pages/France-Antilles-Martinique/366618075391?id=366618075391&sk=app_1441284122774738';
        </script>";
        echo $javascript;
}

$userMan = new UserManager();
$docMan = new DocumentManager();
$appMan = new ApplicationManager();

$application_id = 11;

$appObject = $appMan->getAppliById($application_id);
$page = $appObject->fb_page;
$appId = $appObject->fb_app_id;
$appSecret = $appObject->fb_app_secret;
$id_GA = $appObject->id_google_analytics;

//require('../facebook-php-sdk/src/facebook.php');
require('../../Facebook-Core/facebook-sdk-php/facebook.php');
$facebook = new Facebook(array(
		'appId' => $appId,
		'secret' => $appSecret,
        'allowSignedRequest' => true,
		'cookie' => true ));




$app_path = $_SERVER['REDIRECT_URL'];
$app_path = explode('/', $app_path);
$app_path = $app_path[1];



?>