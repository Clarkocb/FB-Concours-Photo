<?php require_once '../scafold/core.php'; ?>

<?php
    if($_POST){

        if($_FILES['userfile']['error'] == 4){
            $errorFile = "Vous n'avez pas choisi d'image";
        }

        if($_FILES['userfile']['error'] == 2){
            $errorFile = "Votre image est trop volumineuse";
        }

        if(!isset($error)){
            $userId = $_SESSION['user']->id;

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
                header('Location: mesPhotos.php');
            }
        }
    }
 ?>
<?php require_once '../scafold/header.php'; ?>

      <div class="container bkgStart">
        <div class="shareBlock">
            <h1>Votre photo a bien été enregistrée !</h1>
            <h2>Elle est en cours de validation par la rédaction</h2>
            <div class="btn-container">
                <form id="form-inscription" class="autoSend" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

                    <input type="file" name="userfile" style="visibility:hidden;" id="imgFileAuto" />
                        <div class="btn-multi" >
                            <a onclick="$('#imgFileAuto').click();" >
                                <div class="icon-block"><i class="fa fa-upload"></i></div>
                                <div class="btn-txt">Publier une autre photo</div>
                            </a>
                        </div>

                    <?php if(isset($errorFile)) echo '<div class="error">'.$errorFile.'</div>'; ?>



                </form>

                <!-- <div class="btn-multi" id="wall-share" >
                    <div class="icon-block"><i class="fa fa-share"></i></div>
                    <div class="btn-txt">Partager sur mon mur</div>
                </div> -->
                <div class="btn-multi" id="friend-invite" >
                    <div class="icon-block"><i class="fa fa-user"></i></div>
                    <div class="btn-txt">Inviter mes amis à participer</div>
                </div>
            </div>
            <h2>Et maintenant, si vous jetiez un coup d'oeil aux réalisations des autres participants ?</h2>
            <a href="voteRecent.php">
                <div class="btn-multi" style="display: inline-block;">
                    <div class="icon-block"><i class="fa fa-user"></i></div>
                    <div class="btn-txt">Voter pour mes photos favorites</div>
                </div>
            </a>
        </div>

      </div><!-- Container -->

<?php require_once('../scafold/menu.php'); ?>

        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>
