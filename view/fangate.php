<?php require_once '../scafold/core.php';


$signed_request = $facebook->getSignedRequest();
$access_token = $facebook->getAccessToken();

$like_status = $signed_request['page']['liked'];
$uid = $facebook->getUser();

if( $uid ){
	$authorisation = true;
	$user = $facebook->api('me');
	$permissions = $facebook->api("/me/permissions");

	$db_user =	 $userMan->getUserByIdFB($uid);


	if($db_user){
		$_SESSION['user'] = $db_user;
		$isUserAssoc = $userMan->isUserAssoc($db_user->id,$application_id);

		if(!$isUserAssoc){
			$assocId = $userMan->assocUsertoApp($db_user->id,$application_id);
		}

	}else{
		$id_user = $userMan->addFbUser($user);
		$userMan->assocUsertoApp($id_user,$application_id);

		$db_user =	 $userMan->getUserById($id_user);
		$_SESSION['user'] = $db_user;
	}


	if( $_SESSION['redirect'] == true){
			unset($_SESSION['redirect']);
			header('Location: maParticipation.php');
	}



}else{
	$authorisation = false;
	$params = array(
	  'scope' => 'email,user_birthday',
	  'client_id' => $appId,
	  // 'redirect_uri' => 'https://apps.facebook.com/faconcoursphoto'
	  'redirect_uri' => 'https://www.facebook.com/pages/France-Antilles-Martinique/366618075391?sk=app_1441284122774738'
	);

	$loginUrl = $facebook->getLoginUrl($params);
}


//on verifie si l'utilisateur est deja inscrit

/*
$inscrit = $userMan->getInscritByFB($uid);
print_r($inscrit);
if(!is_null($inscrit)){
	$_SESSION['user'] = $inscrit;
	//on verifie si l'utilisateur à deja jouer le jour J
	$userId = $inscrit->id;
	$tentative = $inscritMan->getCurrentTentative($userId);
	$idTentative = $tentative->id;
	if(empty($idTentative)){
		$inscritMan->createTentative($userId);
		$inscritMan->addTentative($userId,1,'tentative');
	}
}

if( !isset($_GET['redirect']) )
{
	if($uid == 0){

	$authorisation = false;
	}else{
	$authorisation = true;
	$user_profile = $facebook->api('me');
	$permissions = $facebook->api("/me/permissions");



	if($permissions[data][0]['publish_stream'] !=1 ) $authorisation = false;


	$_SESSION['fbInfo'] = $user_profile;

	}
}

if(isset($_SESSION['redirect'])) {
	unset($_SESSION['redirect']);
}

//header('Location: play.php');
	if($_GET['redirect'] == true) { $authorisation = true; $like_status=1; } */
?>


<?php require_once '../scafold/header.php'; ?>

        <div class="container bkgStart">
	        <?php if($like_status==0){ ?>
		        <div class="right">
	        		<img src="../img/jaime.gif" />
	        	</div>
	        <?php }else{ ?>
		        <div class="jeParticipe">
		        	<?php   if($authorisation === false) {
				        	// echo '<a href="authentication.php" >
				        	// 		<div class="sprite-btn je-participe" ></div>
				        	// 	</a>';
		        			echo '<a href="'.$loginUrl.'" target="top" >
				        		<div class="sprite-btn je-participe" ></div>
				        	</a>';
			        		}

				        	if($authorisation != false )
				        	{
					        	echo '<a href="maParticipation.php" >
					        			<div class="sprite-btn je-participe" ></div>
					        		</a>';
				        	}
		        	 ?>
	        	</div>
	        <?php } ?>
	        <div class="sprite-txt fangate"></div>

	  </div><!-- Container -->

        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>
