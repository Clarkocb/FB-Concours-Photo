<?php require_once '../scafold/core.php';
/*if(isset($_GET['request_ids'])) {
    print_r($_GET['request_ids']);
    die();
    }*/
$signed_request = $facebook->getSignedRequest();
$access_token = $facebook->getAccessToken();

$like_status = $signed_request['page']['liked'];
$uid = $facebook->getUser();
$_SESSION['pageId'] = $signed_request['page']['id'];
$fb_page = $facebook->api("/".$_SESSION['pageId']);

$_SESSION['indexLink'] = $fb_page['link'].'?sk=app_'.$appId;

$appNamespace = $facebook->api('/'.$appId);
$appNamespace = $appNamespace['namespace'];




if( $uid ){
    $authorisation = true;
    $user = $facebook->api('me');
    $permissions = $facebook->api("/me/permissions");

    //$facebook->api('/me/permissions', 'DELETE');


    $db_user =   $userMan->getUserByIdFB($uid,$application_id);
    if($db_user!=NULL) { $_SESSION['user'] = $db_user;}else{ $_SESSION['fb_user'] = $user;}

    if(isset($signed_request) && $signed_request['app_data']=="redirect") header('Location: inscription.php');

    //header('Location: vote.php');

    // if($db_user){
    //     $_SESSION['user'] = $db_user;
    //     $isUserAssoc = $userMan->isUserAssoc($db_user->id,$application_id);

    //     if(!$isUserAssoc){
    //         $assocId = $userMan->assocUsertoApp($db_user->id,$application_id);
    //     }

    // }else{
    //     $id_user = $userMan->addFbUser($user);
    //     $userMan->assocUsertoApp($id_user,$application_id);

    //     $db_user =   $userMan->getUserById($id_user);
    //     $_SESSION['user'] = $db_user;
    // }



}else{
    $authorisation = false;
    $params = array(
      'scope' => 'email,user_birthday',
      'client_id' => $appId,
      'redirect_uri' => $fb_page['link'].'?sk=app_'.$appId.'&app_data=redirect'
    );

    $loginUrl = $facebook->getLoginUrl($params);
    $_SESSION['loginUrl'] = $loginUrl;
    unset($_SESSION['user']);

}
//header('Location: afterForm.php');
?>

<?php require_once '../scafold/header.php'; ?>

        <?php if($like_status==0){ ?>
                <div class="likeBox">
                    <div id="fangate-like" class="fb-like" data-href="https://www.facebook.com/<?php echo $_SESSION['pageId']; ?>"
                    data-colorscheme="light" data-layout="box_count" data-action="like"
                    data-show-faces="false" data-send="false"></div>
                </div>
        <?php }else{ ?>
        <div class="container bkgStart">
            <div class="txt-header">Jusqu'au 16 mars 2014</div>
                <div class="jeParticipe">
                    <?php   if($authorisation === false) {
                            echo '<a href="'.$loginUrl.'" target="top" >
                                <div class="btn-multi" style="margin-right: 80px;">
                                    <div class="icon-block"><img src="../img/i_photo.png" /></div>
                                    <div class="btn-txt">Je participe au concours</div>
                                 </div>
                            </a>';
                            }

                            if($authorisation != false )
                            {
                                if($db_user===NULL){
                                    echo '<a href="inscription.php" >
                                        <div class="btn-multi" style="margin-right: 80px;">
                                            <div class="icon-block"><img src="../img/i_photo.png" /></div>
                                            <div class="btn-txt">Je participe au concours</div>
                                         </div>
                                    </a>';
                                }else{
                                    echo '<a href="mesPhotos.php" >
                                        <div class="btn-multi" style="margin-right: 80px;">
                                            <div class="icon-block"><img src="../img/i_photo.png" /></div>
                                            <div class="btn-txt">Mes photos</div>
                                         </div>
                                    </a>';
                                }
                            }
                     ?>
                     <a href="voteRecent.php" >
                         <div class="btn-multi">
                            <div class="icon-block"><img src="../img/like.png" /></div>
                            <div class="btn-txt">Je vote pour ma photo favorite</div>
                         </div>
                     </a>
                </div>


      </div><!-- Container -->

<?php require_once('../scafold/menu.php'); ?>

        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>
 <?php }/* Like else */ ?>


 <?php if($like_status==0){
    echo '</body></html>';
    } ?>
