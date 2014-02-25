<?php
require_once '../scafold/core.php';
require_once '../scafold/header.php';

?>

<style>

    .container {
        height: 900px;
        padding: 0px;
    }


</style>

<div class="container bkgGallerie">

    <?php require_once '../scafold/menu-top.php'; ?>


    <div class="gallery-box">
        <div class="sprite-txt txt-popular"></div>
        <?php
            $Documents = $docMan->getDocumentByAppValidated($application_id, 'ORDER BY date_created DESC');

            $numberOfDocument = count($Documents);

            $count = 0;
            $page = 1;
            $itemPerPage = 12;

            $maxPage = $numberOfDocument / $itemPerPage;

            foreach ($Documents as $Image) {
                $isValidate = $Image->validate; ?>

                <?php
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
                        <h1><?php echo $fanName; ?></h1>
                        <div class="photo-box">
                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-150.<?php echo $Image->type; ?>" />
                            </a>
                        </div>
                        <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/dspconcoursphoto#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                    </div>
                    <div class="gallery-unit">
                        <h1><?php echo $fanName; ?></h1>
                        <div class="photo-box">
                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-150.<?php echo $Image->type; ?>" />
                            </a>
                        </div>
                        <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/dspconcoursphoto#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                    </div>
                    <div class="gallery-unit">
                        <h1><?php echo $fanName; ?></h1>
                        <div class="photo-box">
                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-150.<?php echo $Image->type; ?>" />
                            </a>
                        </div>
                        <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/dspconcoursphoto#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                    </div>
                    <div class="gallery-unit">
                        <h1><?php echo $fanName; ?></h1>
                        <div class="photo-box">
                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-150.<?php echo $Image->type; ?>" />
                            </a>
                        </div>
                        <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/dspconcoursphoto#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                    </div>
                    <div class="gallery-unit">
                        <h1><?php echo $fanName; ?></h1>
                        <div class="photo-box">
                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-150.<?php echo $Image->type; ?>" />
                            </a>
                        </div>
                        <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/dspconcoursphoto#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                    </div>
                    <div class="gallery-unit">
                        <h1><?php echo $fanName; ?></h1>
                        <div class="photo-box">
                            <a href="#" data-toggle="modal" data-target="#image<?php echo $Image->id; ?>">
                                <img src="../../Facebook-Core/upload/thumbnail/<?php echo $Image->name; ?>-150.<?php echo $Image->type; ?>" />
                            </a>
                        </div>
                        <div class="fb-like" id="<?php echo $Image->id; ?>" data-href="https://apps.facebook.com/dspconcoursphoto#<?php echo $Image->name; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="tahoma" ></div>
                    </div>
                    <?php
                    if($modulo==0){
                        echo '<div class="pagination-btn">';
                        $previousPage = $page - 1;
                        $nextPage = $page + 1;
                        if($page > 1) echo '<input type="button" class="btn-previous" value="'.$previousPage.'" class="btn-pagination previous-page" />';
                        if($page < $maxPage) echo '<input type="button" class="btn-next" value="'.$nextPage.'" class="btn-pagination next-page" />';
                        echo '</div><!-- pagination-block -->';
                        echo '</div><!-- paginated -->';
                    }
                    /********* Modal Box **********/
                    ?>

                    <!-- Modal -->
                    <div class="modal fade" id="image<?php echo $Image->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">
                                <img src="../upload/thumbnail/<?php echo $Image->name; ?>-500.<?php echo $Image->type; ?>" />
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

        <?php } ?>
    </div>

</div><!-- Container -->

<div class="precache">
</div>
<?php require_once('../scafold/footer.php'); ?>
