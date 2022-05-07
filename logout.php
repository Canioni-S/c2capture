<?php
require_once "./Include/myAutoloader.php";
App::getAuth()->logout();
Session::getInstance()->setFlash("success", "Vous êtes maintenant déconnecté");
App::redirect("login.php");