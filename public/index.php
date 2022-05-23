<?php

use App\App;

define('ROOT', dirname(__DIR__));

require ROOT . "/app/App.php";
App::load();

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'home';
}

ob_start();
if ($page === 'home') {
    require ROOT . "/app/View/home.php";
} elseif ($page === 'collection') {
    require ROOT . "/app/View/collection.php";
} elseif ($page === 'prestation') {
    require ROOT . "/app/View/prestation.php";
} elseif ($page === 'aboutMe') {
    require ROOT . "/app/View/aboutMe.php";
} elseif ($page === 'contact') {
    require ROOT . "/app/View/contact.php";
} elseif ($page === 'login') {
    require ROOT . "/app/View/user/login.php";
} elseif ($page === 'logout') {
    require ROOT . "/app/View/user/logout.php";
} elseif ($page === 'adminPanel') {
    require ROOT . "/app/View/admin/adminPanel.php";
} elseif ($page === 'account') {
    require ROOT . "/app/View/user/account.php";
}
$content = ob_get_clean();
require ROOT . "/app/View/template/default.php";