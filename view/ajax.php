<?php
require_once('../scafold/core.php');


/*********** Add Vote  **************/
if(isset($_POST['action']) && $_POST['action'] == 'vote') {

	$id = $_POST['id'];

	$docMan->DocumentVote($id,'+');
}

/*********** Remove Vote  **************/
if(isset($_POST['action']) && $_POST['action'] == 'unvote') {

	$id = $_POST['id'];

	$docMan->DocumentVote($id,'-');
}

/*********** Admin Validation  **************/
if(isset($_POST['func']) && $_POST['func'] == 'ImageValidation') {

	$id = $_POST['id'];
	$status = $_POST['status'];
	$id_facebook = $_POST['id_facebook'];

	$texte = "Votre image a été approuvé";

	if($status==0) {

		sendNotification($facebook, $appId, $appSecret, $id_facebook, $texte);
	}

	$docMan->DocumentValidation($id, $status);
}


?>