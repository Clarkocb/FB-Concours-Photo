<?php require_once '../scafold/core.php'; ?>

<?php
	if($_POST){
		$d=$_POST;

		if($d['nom']===""){
			$error = true;
			$errorNom = "Ce champs est obligatoire";
		}else{
			if(!preg_match( '/[a-zA-Zéèêëàâäïî\s]{2,25}/', $d['nom'])){
				$error = true;
				$errorNom = "Ce champs est incorrect";
			}
		}

		if($d['prenom']===""){
			$error = true;
			$errorPrenom = "Ce champs est obligatoire";
		}else{
			if(!preg_match( '/[a-zA-Zéèêëàâäïî\s]{2,25}/', $d['nom'])){
				$error = true;
				$errorPrenom = "Ce champs est incorrect";
			}
		}

		if($d['email']===""){
			$error = true;
			$errorEmail = "Ce champs est obligatoire";
		}else{
			if (!preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $d['email'])) {
				$error = true;
				$errorEmail = "Ce champs doit être un email";
			}
		}
		if($d['telephone']===""){
			$error = true;
			$errorTelephone = "Ce champs est obligatoire";
		}else{
			if (!preg_match('(0[56]9[046]\d{6}|(0[56]9[06]\s\d{2}\s\d{2}\s\d{2}))', $d['telephone'])) {
				$error = true;
				$errorTelephone = "Ce téléphone est incorrect";
				print_r($errorTelephone);
			}
		}

		if($d['cgu']!="true"){
			$error = true;
			$errorCGU = "Vous devez accepter le règlement";
		}

		if($_FILES['userfile']['error'] == 4){
            $errorFile = "Vous n'avez pas choisi d'image";
        }

        if($_FILES['userfile']['error'] == 2){
            $errorFile = "Votre image est trop volumineuse";
        }


		if(!isset($error)){
			$form['nom'] = $d['nom'];
			$form['prenom'] = $d['prenom'];
			$form['email'] = $d['email'];
			$form['telephone'] = $d['telephone'];
			$form['id_application'] = $application_id;
			$id = $userMan->addFbUserByForm($_SESSION['fb_user'],$form);
			$userMan->assocUsertoApp($id,$application_id);

			unset($_SESSION['fb_user']);
			$db_user =   $userMan->getUserById($id);
        	$_SESSION['user'] = $db_user;

        	/****** Add Document foncionnality *****/
        	$userId = $id;

	        $date = date_create();
	        $date = date_timestamp_get($date);

	        $encryptedName = hash('md5', $date);

	        $filename = $userId.'-'.$encryptedName;

	        $uploadDir = "../../Facebook-Core/upload/";

	        $extention = substr( $_FILES['userfile']['name'], -3 );

	        $uploadFile = $uploadDir.$filename.'.'.$extention;


	        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {

	            make_thumbProportional($uploadFile,$uploadDir . '/thumbnail/' . $filename.'-600.'.$extention , 600 , $extention);
	            make_thumb($uploadFile,$uploadDir . '/thumbnail/' . $filename.'-160.'.$extention , 160 , $extention);

	            $idDoc = $docMan->addDocument($userId,$application_id, $filename, $extention);
	            $docMan->updateDocByValue($idDoc,'statut','pending');
	            $appMan->updateAppOption($idDoc, 'cp_view_count', 0);
	            /** add Coefficient Score **/
	            $appMan->updateAppOption($idDoc, 'cp_multiply', 1);
	            header('Location: afterForm.php');
	        }
		}

		// $userMan->cleanUpThatShit($application_id);
	}


 ?>

<?php require_once '../scafold/header.php'; ?>

      <div class="container bkgStart">
            <div class="txt-header">Jusqu'au 16 mars 2014</div>
			<div class="inscription-block">
	            <form id="form-inscription" enctype="multipart/form-data" method="POST">
					<input type="text" name="nom" value="<?php if($error===true) echo $d['nom']; ?>" placeholder="nom" />
					<?php if(isset($errorNom)) echo '<div class="error">'.$errorNom.'</div>'; ?>
					<input type="text" name="prenom" value="<?php if($error===true) echo $d['prenom']; ?>" placeholder="prénom" />
					<?php if(isset($errorPrenom)) echo '<div class="error">'.$errorPrenom.'</div>'; ?>
					<input type="text" name="email" value="<?php if($error===true) echo $d['email']; ?>" placeholder="email" />
					<?php if(isset($errorEmail)) echo '<div class="error">'.$errorEmail.'</div>'; ?>
					<input type="text" name="telephone" value="<?php if($error===true) echo $d['telephone']; ?>" placeholder="téléphone" />
					<?php if(isset($errorTelephone)) echo '<div class="error">'.$errorTelephone.'</div>'; ?>
					<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
	            	<!-- <input type="file" name="userfile" /> -->

					<div class="info-file">
						Proposer votre 1ère photo (poids max de 3Mo)
					</div>
					<input type="file" name="userfile" style="visibility:hidden;height: 18px;" id="imgFile" />
					<div class="input-append">
					    <input type="text" name="subfile" id="subfile" class="input-xlarge" readonly="">
					    <a class="btn fakeBrowse" onclick="$('#imgFile').click();">Parcourir</a>
					</div>



					<?php if(isset($errorFile)) echo '<div class="error">'.$errorFile.'</div>'; ?>



					<div class="checkboxFive">
		                <input type="checkbox" id="checkboxFiveInput" name="cgu" value="true" />
		                <label for="checkboxFiveInput"></label>
	            	</div>
					<span>j'accepte le règlement</span>
					<?php if(isset($errorCGU)) echo '<div class="error" style="padding-left:80px;">'.$errorCGU.'</div>'; ?>

					<!-- <input type="submit" name="valid" value="Je participe au concours" /> -->
					<div class="btn-multi" id="send-form" >
                        <div class="icon-block"><img src="../img/i_photo.png" /></div>
                        <div class="btn-txt">Je participe au concours</div>
                    </div>
	            </form>
	        </div>

      </div><!-- Container -->

<?php require_once('../scafold/menu.php'); ?>

        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>
