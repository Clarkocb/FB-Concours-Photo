<?php require_once '../scafold/core.php'; ?>

<?php
//$docMan->deleteDocByAppid($application_id);

$user_id = $_SESSION['user']->id;

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

        $extention = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        if($extention=="jpeg") $extention = "jpg";
        $uploadFile = $uploadDir.$filename.'.'.$extention;


        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {


            make_thumbProportional($uploadFile,$uploadDir . '/thumbnail/' . $filename.'-600.'.$extention , 600 , $extention);
            make_thumb($uploadFile,$uploadDir . '/thumbnail/' . $filename.'-160.'.$extention , 160 , $extention);

            $idDoc = $docMan->addDocument($userId,$application_id, $filename, $extention);
            $docMan->updateDocByValue($idDoc,'statut','pending');
            $appMan->updateAppOption($idDoc, 'cp_view_count', 0);
            /** add Coefficient Score **/
            $appMan->updateAppOption($idDoc, 'cp_multiply', 1);
        }
    }
}

$Documents = $docMan->getDocumentByUserId($appObject->id, $user_id, 'Order by date_created DESC');

?>

<?php require_once '../scafold/header.php'; ?>
<style>
    .shareBlock .btn-multi {
        display: inline-block;
    }
</style>
<div class="container bkgStart" id="page-mesPhotos">
    <div class="content-block">
        <?php require_once '../scafold/menu-top.php'; ?>

        <?php
        $numberOfDocument = count($Documents);

        $count = 0;
        $page = 1;
        $itemPerPage = 2;

        $maxPage = $numberOfDocument / $itemPerPage;

        foreach ($Documents as $Image) {
            $count++;
            $modulo = $count % $itemPerPage;

            if($modulo==1 && $count > 1) $page++;
            if($modulo==1){
                echo '<div id="page-'.$page.'" class="paginated">';
            }

            $user = $userMan->getUserById($Image->user_id);
            $fanName = substr( $user->fb_name, 0 , 20);

            $cp_view_count = $appMan->getAppOption($Image->id, 'cp_view_count');
            $cp_multiply = $appMan->getAppOption($Image->id, 'cp_multiply');
            $cp_date_valid = $appMan->getAppOption($Image->id, 'cp_date_valid');

            $dateSoumission = dateMYSQLtoFR($Image->date_created);
            $dateValidation = dateMYSQLtoFR($cp_date_valid->value);

            $statut = $Image->statut;
            $score = $Image->vote * $cp_multiply;


            ?>
            <div class="mesPhotos-block">
                <div class="row" style="height: 160px;">
                    <div class="photo-box">
                        <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-160.<?php echo $Image->type; ?>" />
                    </div>
                    <div class="info">
                        <p><span class="bold">Date de soumission</span> : <?php echo $dateSoumission; ?></p>
                        <?php if($statut=="valid"){ ?>
                        <p><span class="bold">Date de validation</span> : <?php echo $dateValidation; ?></p>
                        <?php }elseif($statut=="pending"){ ?>
                        <p><span class="bold">Date de validation</span> : En cours</p>
                        <?php } ?>
                        <!-- <p><span class="bold">Nombre de vues</span> : <?php echo $cp_view_count->value; ?></p> -->
                        <p><span class="bold">Nombre de likes</span> : <?php echo $Image->vote; ?></p>
                        <!-- <p><span class="bold">Note de la rédaction</span> : <?php echo $cp_multiply->value; ?></p> -->
                    </div>
                </div>

                <div class="row"  style="height: 42px;">
                    <div class="underImage-block">
                        <div class="shareBox">
                        </div>

                        <?php if($statut=="valid"){ ?>
                                <div class="btn-box valid">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                        <?php } ?>
                        <?php if($statut=="pending"){ ?>
                                <div class="btn-box pending">
                                    <i class="fa fa-spinner"></i>
                                </div>
                        <?php } ?>
                        <?php if($statut=="denied"){ ?>
                                <div class="btn-box denied">
                                    <i class="fa fa-times-circle"></i>
                                </div>
                        <?php } ?>

                    </div>

                    <div class="score-block">
                        <!-- Score : <?php echo $score; ?> -->
                    </div>

                </div>

                <!-- <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/<?php echo $app_path; ?>#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div> -->
            </div>
            <?php
            if($modulo==0 or $numberOfDocument==$count){
                echo '<div class="pagination-btn">';
                $previousPage = $page - 1;
                $nextPage = $page + 1;
                // if($page > 1) echo '<input type="button" class="btn-previous" value="'.$previousPage.'" class="fa fa-chevron-left" />';
                // if($page < $maxPage) echo '<input type="button" class="btn-next" value="'.$nextPage.'" class="fa fa-chevron-left" />';

                    if($page > 1) {
                         echo '<a href="#" class="btn-previous"><i class="fa fa-chevron-left"></i>Page précédente</a>';
                    }
                    if($page < $maxPage) {
                         echo '<a href="#" class="btn-next">Page suivante <i class="fa fa-chevron-right btn-next"></i></a>';
                    }

                echo '</div><!-- pagination-block -->';
                echo '</div><!-- paginated -->';
            }

        }
        ?>

        <div class="action-block">
            <div class="col-sm-6">
                <form id="form-mesPhotos" class="autoSend" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

                    <input type="file" name="userfile" style="visibility:hidden;" id="imgFileAuto" />
                    <div class="btn-multi" >
                        <a onclick="$('#imgFileAuto').click();" >
                            <div class="icon-block"><i class="fa fa-upload"></i></div>
                            <div class="btn-txt">Publier une autre photo</div>
                        </a>
                    </div>
                    <!-- <input type="submit" value="Vwéyé i Salope la"> -->

                    <?php if(isset($errorFile)) echo '<div class="error">'.$errorFile.'</div>'; ?>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="btn-multi" id="friend-invite" >
                    <div class="icon-block"><i class="fa fa-user"></i></div>
                    <div class="btn-txt">Inviter mes amis à participer</div>
                </div>
            </div>



        </div>

    </div>

</div><!-- Container -->

<?php require_once('../scafold/menu.php'); ?>

<div class="precache">
</div>
<?php require_once('../scafold/footer.php'); ?>
