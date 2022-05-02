<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once './Include/pdo.php';
require_once "./Functions/adminFunction.php";
// GET ALL COLLECTIONS
$navCollections = getAllCollections();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <?php if (isset($extraCss)) {
        echo '<link rel="stylesheet" href="/css/' . $extraCss . '.css">';
    } ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title><?= $title; ?></title>
</head>

<body>
    <!-- NAVBAR -->
    <div id="goTop" class="navLogoContainer">
        <a id="navLogo" class="navLogo" href="/home.php"><img class="navLogoImg" src="/Assets/pictures/logoDark.png" alt="Logo kla photographie"></a>
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
                <button onclick="iconRotate()"  id="navDropBtn" class="accordion navDropBtn">Les Collections<i id="iconRotate" class="bi bi-caret-right-fill"></i></button>
                <div id="dropContent" class="navDropdownContent">
                    <?php foreach ($navCollections as $navCollection) : ?>
                        <div class="navCatContainer">
                            <button class="accordion navCatBtn">Collection '<?= $navCollection[1]; ?>'</button>
                            <div class="panel">
                                <?php
                                $navGalleries = getAllGallByColl($navCollection[0]);
                                foreach ($navGalleries as $navGallery) : ?>
                                    <a class="navLinkDropdown" href="../gallery.php?id=<?= $navGallery[0]; ?>">Galerie : <?= $navGallery[2] ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="../prestation.php" class="navLink">prestations</a>
            <a href="../aboutMe.php" class="navLink">qui-suis-je ?</a>
            <a href="../contact.php" class="navLink">contact</a>

            <div class="navMemberIcon">
                <?php if (isset($_SESSION['auth'])) : ?>
                    <div class="iconItem">
                        <a href="logout.php" class="navLink"><i class="bi bi-x-circle red"></i></a>
                        <span class="navTooltipText">Se déconnecter</span>
                    </div>
                <?php endif; ?>
                <div class="iconItem">
                    <a href="/login.php" class="navLink"><i class="bi bi-person-circle"></i></a>
                    <span class="navTooltipText">Espace Membre</span>
                </div>
            </div>

        </nav>
        <hr>
    </div>

    <div class="alertMsgBox">
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div class="alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
    </div>