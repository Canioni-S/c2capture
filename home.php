<?php
$title = "Acceuil";
$extraCss = "home";
require_once './Include/navbar.php'
?>

<div class="homePageContainer">
    
    <div class="titleContainer">
        <h1>Bienvenu sur mon blog photo, vous trouverez ici différentes collections composées de plusieurs galeries de photos</h1>
    </div>

    <?php
    $collections = getAllCollections();

    foreach ($collections as $collection) :
        $galery = getFirstGallbyColl($collection[0]);
        $picture = getFirstPicByGall($galery[0]);
    ?>

        <a class="collectionContainer" href="./collection.php?id=<?= $collection[0];?>">
            <img class="imgCollection" src="<?= $picture[3]; ?>" alt="<?= $picture[2]; ?>">
            <p class="nameCollection">Collection : '<?= $collection[1]; ?>'</p>
        </a>

        <hr>
    <?php endforeach; ?>
</div>


<?php require_once './Include/footer.php' ?>