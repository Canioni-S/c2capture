<?php

use App\App;

?>

<div id="goTop" class="navLogoContainer">
    <a id="navLogo" class="navLogo" href="index.php?p=home"><img class="navLogoImg" src="/asset/pictures/logoDark.png" alt="Logo kla photographie"></a>
</div>
<div class="navbarContainer">
    <hr>
    <nav id="navbar" class="navbar">

        <div class="MenuBurgerContainer" onclick="Burgerfunction(this)">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>

        <div class="navDropdown">
            <button onclick="iconRotate()" id="navDropBtn" class="accordion navDropBtn">Les Collections<i id="iconRotate" class="bi bi-caret-right-fill"></i></button>
            <div id="dropContent" class="navDropdownContent">

                <?php
                foreach (App::getInstance()->getTable('COLLECTIONS')->findAll() as $navCollection) : ?>
                    <div class="navCatContainer">
                        <button class="accordion navCatBtn">Collection '<?= $navCollection->NAME_COLL; ?>'</button>
                        <div class="panel">

                            <?php
                            foreach (App::getInstance()->getTable('GALLERIES')->findAllGallFromColl($navCollection->ID_COLL) as $navGallery) : ?>
                                <a class="navLinkDropdown" href="<?= $navGallery->getUrl() ?>">Galerie : <?= $navGallery->NAME_GALL ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <a href= "index.php?p=prestation" class="navLink">prestations</a>
        <a href= "index.php?p=aboutMe" class="navLink">qui-suis-je ?</a>
        <a href= "index.php?p=contact" class="navLink">contact</a>

        <div class="navMemberIcon">
            <?php if (isset($_SESSION['auth'])) : ?>
                <div class="iconItem">
                    <a href="index.php?p=logout" class="navLink"><i class="bi bi-x-circle red"></i></a>
                    <span class="navTooltipText">Se déconnecter</span>
                </div>
            <?php endif; ?>
            <div class="iconItem">
                <a href="index.php?p=login" class="navLink"><i class="bi bi-person-circle"></i></a>
                <span class="navTooltipText">Espace Membre</span>
            </div>
        </div>

    </nav>
    <hr>
</div>