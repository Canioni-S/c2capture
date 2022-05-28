<?php

use App\App;

$gallery = App::getInstance()->getTable('GALLERIES')->findOneGall(htmlentities($_GET['id']));

$pictures = App::getInstance()->getTable('PICTURES')->getAllPicByGall($gallery->ID_GALL);

$title =  $gallery->NAME_GALL;
$extraCss = "gallery";
?>

<div class="pageContainer">
    <div class="titleContainer">
        <h1>GALERIE : ' <?= $gallery->NAME_GALL; ?> '</h1>
    </div>
    <div class="page">
        <div class="descriptionContainer">
            <p><?= $gallery->DESCRIPTION_GALL; ?></p>
        </div>
        <?php if (!empty($pictures)) : ?>
            <div class="allCardContainer">
                <?php foreach ($pictures as $picture) : ?>
                    <div class="card">
                        <a href="#imgId<?= $picture->NAME_PIC; ?>" class="">
                            <div class="imgContainer">
                                <img class="img" src="<?= $picture->LINK_PIC; ?>" alt="<?= $picture->NAME_PIC; ?>">
                                <span class="imgTitle"><?= $picture->NAME_PIC ?></span>
                            </div>
                        </a>
                    </div>
                    <div class="overlayContainer">
                        <a href="#_" class="overlay" id="imgId<?= $picture->NAME_PIC; ?>">
                            <img src="<?= $picture->LINK_PIC; ?>" alt="<?= $picture->NAME_PIC; ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif ?>
    </div>
</div>