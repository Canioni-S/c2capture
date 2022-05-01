<?php
require_once "./Functions/adminFunction.php";
adminOnly();

$collections = getAllCollections();

?>

<!-- ADMIN PANEL VIEX -->
<?php
$title = "Page admin";
$extraCss = "admin";

?>

<?php require_once './Include/navbar.php'; ?>
<div class="adminPageContainer">
    <div class="adminPage">

        <h1>ADMIN</h1>


        <div class="adminBtnGrp">
            <button class="adminBtn add">
                <a class="adminLink" href="./adminAddColl.php"><i class="icon bi bi-plus">Collection</i></a>
            </button>
        </div>


        <?php foreach ($collections as $collection) : ?>
            <div class="adminItem">
                <div class="adminPanel category">

                    <h2>Collection : '<?= $collection[1]; ?>'</h2>
                    <div class="adminPanelBtn">

                        <div class="adminBtnGrp">
                            <button class="adminBtn add">
                                <a class="adminLink" href="./adminAddGall.php?id=<?= $collection[0]; ?>">
                                    <i class="icon bi bi-plus">Galerie</i>
                                </a>
                            </button>
                        </div>

                        <div class="adminBtnGrp">
                            <button class="adminBtn edit">
                                <a class="adminLink" href='./adminEditColl.php?id=<?= $collection[0]; ?>'><i class="icon bi bi-pencil"></i></a>
                            </button>
                        </div>

                        <div class="adminBtnGrp">
                            <button class="adminBtn delete" onclick="return confirm('Voulez vous vraiment supprimer cette collection ? ATTENTION, toutes les galeries et photos de cette collection seront supprimées!')">
                                <a class="adminLink" href='./adminDeleteColl.php?id=<?= $collection[0]; ?>'><i class="icon deletee bi bi-trash"></i></a>
                            </button>
                        </div>

                    </div>

                </div>

                <?php
                $galleries = getAllGallByColl($collection[0]);
                foreach ($galleries as $gallery) : ?>

                    <div class="adminPanel collection">

                        <h3>Galerie : <?= $gallery[2]; ?></h3>

                        <div class="adminPanelBtn">
                            <button class="adminBtn add">
                                <a class="adminLink" href='./adminAddPic.php?id=<?= $gallery[0]; ?>'><i class="icon bi bi-plus"></i><i class="icon bi bi-images"></i></a>
                            </button>
                            <button class="adminBtn edit">
                                <a class="adminLink" href='./adminEditGall.php?id=<?= $gallery[0]; ?>'><i class="icon bi bi-pencil"></i></a>
                            </button>
                            <button class="adminBtn delete" onclick="return confirm('Voulez vous vraiment supprimer cette galerie ? ATTENTION, toutes les photos de cette galerie seront supprimées!')">
                                <a class="adminLink" href='./adminDeleteGall.php?id=<?= $gallery[0]; ?>'><i class="icon bi bi-trash"></i></a>
                            </button>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require './Include/footer.php'; ?>