<?php require_once '../scafold/core.php';

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

        header('Location: mesPhotos.php');
    }
}

?>

<?php require_once '../scafold/header.php'; ?>

        <div class="container bkgStart" id="page-gallery">
                <div class="content-block">
                    <?php require_once '../scafold/menu-top.php'; ?>
                        <?php
                            $Documents = $docMan->getDocumentByAppValidated($application_id, 'ORDER BY vote DESC');

                            $numberOfDocument = count($Documents);

                            $count = 0;
                            $page = 1;
                            $itemPerPage = 8;

                            $maxPage = $numberOfDocument / $itemPerPage;

                            foreach ($Documents as $Image) {
                                $isValidate = $Image->validate;
                                $cp_multiply = $appMan->getAppOption($Image->id, 'cp_multiply');
                                $score = $Image->vote * $cp_multiply->value;

                                    $count++;
                                    $modulo = $count % $itemPerPage;
                                    if($modulo==1 && $count > 1) $page++;
                                    if($modulo==1){
                                        echo '<div id="page-'.$page.'" class="paginated">';
                                    }

                                    $user = $userMan->getUserById($Image->user_id);
                                    $fanName = substr( $user->fb_name, 0 , 20);
                                 ?>
                                    <div class="gallery-unit">
                                        <div class="photo-box">
                                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-160.<?php echo $Image->type; ?>" />
                                            </a>
                                        </div>
                                        <!-- <div class="underImage-block">
                                            <div class="shareBox">
                                                <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/<?echo $app_path; ?>#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                                            </div>

                                            <div class="btn-box">
                                                <div class="score">Score</div>
                                                <span><?php echo $score ?></span>
                                            </div>

                                        </div> -->

                                        <div class="underImage-block">
                                            <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/<?echo $app_path; ?>#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                                            </div>
                                        </div>


                                    <!-- Modal -->
                                    <div class="modal fade" id="image<?php echo $Image->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                                <img class="modal-thumb" src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-600.<?php echo $Image->type; ?>" />
                                          </div>
                                        </div><!-- /.modal-content -->
                                      </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->


                                    <?php
                                    if($modulo==0 or $numberOfDocument==$count){
                                        echo '<div class="pagination-btn">';
                                        $previousPage = $page - 1;
                                        $nextPage = $page + 1;
                                        if($page > 1) {
                                             echo '<a href="#" class="btn-previous"><i class="fa fa-chevron-left"></i>Page précédente</a>';
                                        }
                                        if($page < $maxPage) {
                                             echo '<a href="#" class="btn-next">Page suivante <i class="fa fa-chevron-right btn-next"></i></a>';
                                        }
                                        echo '</div><!-- pagination-block -->';
                                        echo '</div><!-- paginated -->';
                                    }
                                    /********* Modal Box **********/
                                    ?>



                        <?php } ?>

                        <?php if(isset($_SESSION['user'])){ ?>
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
                        </div>
                        <?php }else{ ?>
                        <div class="btn-container">
                            <a href="<?php echo $_SESSION['loginUrl']; ?>" target="top" >
                                <div class="btn-multi" style="margin-right: 80px;">
                                    <div class="icon-block"><img src="../img/i_photo.png" /></div>
                                    <div class="btn-txt">Je participe au concours</div>
                                 </div>
                            </a>
                        </div>
                        <?php } ?>

                    </div>
                </div>


      </div><!-- Container -->

<?php require_once('../scafold/menu.php'); ?>

        <div class="precache">
        </div>
 <?php require_once('../scafold/footer.php'); ?>