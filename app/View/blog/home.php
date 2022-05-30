<?php

use App\App;

?>

<div class="homePageContainer">

    <div class="titleContainer">
        <h1>Bienvenu sur mon blog photo, vous trouverez ici différentes collections composées de plusieurs galeries de photos</h1>
    </div>

    <?php

    foreach ($collections as $collection) :
        $gallery = App::getInstance()->getTable('GALLERIES')->findFirstGall($collection->ID_COLL);
        $picture = App::getInstance()->getTable('PICTURES')->findFirstPic($gallery->ID_GALL);
    ?>
        <a class="collectionContainer" href="<?= $collection->getUrl() ?>">
            <img class="imgCollection" src="<?= $picture->LINK_PIC; ?>" alt="<?= $picture->NAME_PIC; ?>">
            <p class="nameCollection">Collection : '<?= $collection->NAME_COLL; ?>'</p>
        </a>

        <hr>
    <?php endforeach; ?>
</div>