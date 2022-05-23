<?php

use App\App;

App::getAuth()->adminOnly();
?>

<!-- ADMIN PANEL VIEW -->
<?php
$title = "Page admin";
$extraCss = "admin"; ?>

<div class="adminPageContainer">
    <div class="adminPage">

        <h1>ADMIN</h1>

        <!-- BUTTON TO ADD A NEW COLLECTION -->
        <div class="adminBtnGrp">
            <button class="adminBtn add">
                <a class="adminLink" href="./adminAddColl.php"><i class="icon bi bi-plus">Collection</i></a>
            </button>
        </div>

        <?php
        // GET ALL THE COLLECTIONS INFORMATIONS AND CREATE FOR EACH COLLECTION A PANEL WITH BUTTONS 
        foreach (App::getInstance()->getTable('COLLECTIONS')->findAll() as $collection) : ?>

            <div class="adminItem">
                <div class="adminPanel category">

                    <h2>Collection : '<?= $collection->NAME_COLL; ?>'</h2>

                    <div class="adminPanelBtn">

                        <!-- BUTTON TO ADD A NEW GALLERY TO THE CORRESPONDING COLLECTION -->
                        <button class="adminBtn add">
                            <a class="adminLink" href="./adminAddGall.php?id=<?= $collection->ID_COLL; ?>"><i class="icon bi bi-plus">Galerie</i></a>
                        </button>

                        <!-- BUTTON TO MODIFY THE CORRESPONDING COLLECTION -->
                        <button class="adminBtn edit">
                            <a class="adminLink" href='./adminEditColl.php?id=<?= $collection->ID_COLL; ?>'><i class="icon bi bi-pencil"></i></a>
                        </button>

                        <!-- BUTTON TO DELETE THE CORRESPONDING COLLECTION -->
                        <button class="adminBtn delete" onclick="return confirm('Voulez vous vraiment supprimer cette collection ? ATTENTION, toutes les galeries et photos de cette collection seront supprimées!')">
                            <a class="adminLink" href='./adminDeleteColl.php?id=<?= $collection->ID_COLL; ?>'><i class="icon deletee bi bi-trash"></i></a>
                        </button>

                    </div>

                </div>

                <?php
                // GET ALL THE GALLERIES INFORMATIONS FOR EACH COLLECTION AND CREATE A PANEL WITH BUTTONS FOR EACH GALLERY
                foreach (App::getInstance()->getTable('GALLERIES')->findAllGallFromColl($collection->ID_COLL) as $gallery) : ?>

                    <div class="adminPanel collection">

                        <h3>Galerie : <?= $gallery->NAME_GALL; ?></h3>

                        <div class="adminPanelBtn">

                            <!-- BUTTON TO ADD A NEW PICTURE TO THE CORRESPONDING GALLERY -->
                            <button class="adminBtn add">
                                <a class="adminLink" href='./adminAddPic.php?id=<?= $gallery->ID_GALL; ?>'><i class="icon bi bi-plus"></i><i class="icon bi bi-images"></i></a>
                            </button>

                            <!-- BUTTON TO MODIFY THE CORRESPONDING GALLERY -->
                            <button class="adminBtn edit">
                                <a class="adminLink" href='./adminEditGall.php?id=<?= $gallery->ID_GALL; ?>'><i class="icon bi bi-pencil"></i></a>
                            </button>

                            <!-- BUTTON TO DELETE THE CORRESPONDING GALLERY -->
                            <button class="adminBtn delete" onclick="return confirm('Voulez vous vraiment supprimer cette galerie ? ATTENTION, toutes les photos de cette galerie seront supprimées!')">
                                <a class="adminLink" href='./adminDeleteGall.php?id=<?= $gallery->ID_GALL; ?>'><i class="icon bi bi-trash"></i></a>
                            </button>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php endforeach; ?>

    </div>
</div>