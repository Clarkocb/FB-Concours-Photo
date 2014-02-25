<?php
    $current_file = $_SERVER['PHP_SELF'];
    $current_file = explode('/', $current_file);
    $current_file = $current_file[3];
 ?>
            <div class="top-menu">
                <a href="<?php echo $_SESSION['indexLink']; ?>" target="_top">
                    Accueil
                </a>
                <!-- <a href="voteVue.php" <?php if($current_file=="voteVue.php") echo 'class="active"'; ?> >Photos les plus vues</a> -->
                <a href="votePopular.php" <?php if($current_file=="votePopular.php") echo 'class="active"'; ?> >Photos les plus populaires</a>
                <a href="voteRecent.php" <?php if($current_file=="voteRecent.php") echo 'class="active"'; ?> >Photos les plus récentes</a>
                <?php if(isset($_SESSION['user'])) {?>
                <a href="mesPhotos.php" <?php if($current_file=="mesPhotos.php") echo 'class="active"'; ?>>Mes photos</a>
                <?php } ?>
            </div>