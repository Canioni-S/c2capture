<?php

use App\App;
use App\Session;

App::getAuth()->logout();
Session::getInstance()->setFlash("success", "Vous êtes maintenant déconnecté");
App::redirect("index.php?p=home");
