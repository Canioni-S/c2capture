<?php

use App\App;
use App\Session;

$db = App::getInstance()->getDB();

if (App::getAuth()->confirm($db, $_GET['id'], $_GET['token'])) {
    Session::getInstance()->setFlash("success", "Votre compte a bien été validé");
    App::redirect("index.php?p=account");
} else {
    Session::getInstance()->setFlash("danger", "Ce token n'est plus valide");
    App::redirect("index.php?p=login");
}
