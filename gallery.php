<?php
require_once "./Functions/adminFunction.php";

// FETCH THE CONTENT OF A GALLERY TO ADD IN THE RIGHT TABLE
$gallery = getGallery(htmlentities($_GET['id']));

// FETCH THE CONTENT OF A GALLERY (PICTURES) TO USE THE GALLERY'S INFORMATIONS IN THE VIEW
$pictures = getAllPicByGall($gallery[0]);

$title =  $gallery[2];
$extraCss = "gallery";
?>

<?php require_once './Include/navbar.php'; ?>

<div class="pageContainer">
    <div class="titleContainer">
        <h1>GALERIE : ' <?= $gallery[2]; ?> '</h1>
    </div>
    <div class="page">
        <div class="descriptionContainer">
            <p><?= $gallery[3]; ?></p>
        </div>
        <?php if (!empty($pictures)) : ?>
            <div class="allCardContainer">
                <?php foreach ($pictures as $picture) : ?>
                    <div class="card">
                        <a href="#imgId<?= $picture[2]; ?>" class="">
                            <div class="imgContainer">
                                <img class="img" src="<?= $picture[3]; ?>" alt="<?= $picture[2]; ?>">
                                <span class="imgTitle"><?= $picture[2] ?></span>
                            </div>
                        </a>
                    </div>
                    <div class="overlayContainer">
                        <a href="#_" class="overlay" id="imgId<?= $picture[2]; ?>">
                            <img src="<?= $picture[3]; ?>" alt="<?= $picture[2]; ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif ?>
    </div>
</div>
</div>
<?php require_once './Include/footer.php'; ?>