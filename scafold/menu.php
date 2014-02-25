<div class="menu-bottom">
    <a href="<?php echo $_SESSION['indexLink']; ?>" target="_top">
        Accueil
    </a>
    <?php if(isset($_SESSION['user'])) {?>
    <a href="mesPhotos.php">
        Mes photos
    </a>
    <?php } ?>
    <!-- <a href="voteView.php">
        Photos les plus vues
    </a> -->
    <a href="votePopular.php">
        Photos les plus populaires
    </a>
    <a href="voteRecent.php">
        Photos les plus récentes
    </a>
    <a href="faq.php">
        FAQ
    </a>
</div>