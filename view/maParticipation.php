<?php require_once '../scafold/core.php';

if($_POST){

    if($_FILES['userfile']['error'] == 0 && isset($_POST['cgu'])){


        $userId = $_SESSION['user']->id;

        $date = date_create();
        $date = date_timestamp_get($date);

        $encryptedName = hash('md5', $date);

        $filename = $userId.'-'.$encryptedName;

        $uploadDir = "../../Facebook-Core/upload/";

        $extention = substr( $_FILES['userfile']['name'], -3 );

        $uploadFile = $uploadDir.$filename.'.'.$extention;


        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {

            make_thumb($uploadFile,$uploadDir . '/thumbnail/' . $filename.'-500.'.$extention , 500 , $extention);
            make_thumb($uploadFile,$uploadDir . '/thumbnail/' . $filename.'-150.'.$extention , 150 , $extention);

            $idDoc = $docMan->addDocument($userId,$application_id, $filename, $extention);
            $docMan->updateDocByValue($idDoc,'statut','pending');
            $appMan->updateAppOption($idDoc, 'cp_view_count', 0);
            /** add Coefficient Score **/
            $appMan->updateAppOption($idDoc, 'cp_multiply', 1);
            header('Location: afterForm.php');
        } else {
            $error = "Il y a un soucis technique, Veuillez recommencer.";
        }

    }else{

        if($_FILES['userfile']['error'] == 4){
            $error = "Vous n'avez pas choisi d'image";
        }

        if($_FILES['userfile']['error'] == 2){
            $error = "Votre image est trop volumineuse";
        }

        if(!isset($_POST['cgu'])) {
            $error = 'Vous devez accepter le réglement';
        }
    }

}





function make_thumb($src, $dest, $desired_width, $extention) {

    /* read the source image */
    if($extention=='jpg') $source_image = imagecreatefromjpeg($src);
    if($extention=='png') $source_image = imagecreatefrompng($src);
    if($extention=='gif') $source_image = imagecreatefromgif($src);

    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    imagejpeg($virtual_image, $dest);
}


?>



<?php require_once '../scafold/header.php'; ?>




    <div class="container bkgStart">

    <?php require_once '../scafold/menu-top.php'; ?>

    <?php if($error) echo '<div class="div-error radius">'.$error.'</div>'; ?>

    <form enctype="multipart/form-data" method="post">
        <div class="sprite-txt maParticipation inputfile">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <input type="file" name="userfile" />
        </div>
        <div class="sprite-txt txt-reglement">
            <div class="checkboxFive">
                <input type="checkbox" id="checkboxFiveInput" name="cgu" value="true" />
                <label for="checkboxFiveInput"></label>
            </div>
        </div>
        <input type="submit" value="Je valide" class="sprite-btn btn-maParticipation">
    </form>



    </div><!-- Container -->

        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>
