<?php
$title = "Liste des galeries";
$extraCss = "home";
require_once './Include/navbar.php';
$id_coll = htmlentities($_GET['id']);
$collection = getCollection($id_coll);
$galleries = getAllGallByColl($id_coll);
?>


<!-- VIEW OF ALL THE GALLERIES OF A COLLECTION -->

<div class="homePageContainer">

    <div class="titleContainer">
        <h1>Voici les differentes galeries composant la collection '<?= $collection[1]; ?>'</h1>
    </div>

    <?php foreach ($galleries as $gallery) :
        $picture = getFirstPicByGall($gallery[0]); ?>

        <a class="collectionContainer" href="./gallery.php?id=<?= $gallery[0];?>">
            <img class="imgCollection" src="<?= $picture[3]; ?>" alt="<?= $picture[2]; ?>">
            <p class="nameCollection">Galerie : '<?= $gallery[2]; ?>'</p>
        </a>
        <hr>

    <?php endforeach; ?>
</div>


<?php require_once './Include/footer.php' ?>