<?php

use App\Session; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" ?>
    <?php
    if (isset($extraCss)) {
        echo '<link rel="stylesheet" href="/css/' . $extraCss . '.css">';
    }
    if (isset($title)) {
        echo "<title>" .  $title . "</title>";
    } 
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body>

    <?php
    require_once 'navbar.php'
    ?>

    <div class="alertMsgBox">
        <?php if (Session::getInstance()->hasFlashes()) : ?>
            <?php foreach (Session::getInstance()->getFlashes() as $type => $message) : ?>
                <div class="alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?= $content ?>

    <?php
    require_once 'footer.php'
    ?>

</body>

<script src="/js/script.js"></script>

</html>