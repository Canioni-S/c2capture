<?php

use App\App;
use App\DBAuth;

define('ROOT', dirname(__DIR__));

require ROOT . "/app/App.php";
App::load();

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'home';
}

$app = App::getInstance();
$auth = new DBAuth($app->getDB());
if(!$auth->logged()){
    $app->forbidden();
}

ob_start();
if ($page === 'home') {
    require ROOT . "/app/View/admin/adminPanel.php";
} elseif ($page === 'collection') {
    require ROOT . "/app/View/admin/collection.php";
} elseif ($page === 'prestation') {
    require ROOT . "/app/View/admin/prestation.php";
} elseif ($page === 'aboutMe') {
    require ROOT . "/app/View/admin/aboutMe.php";
} elseif ($page === 'contact') {
    require ROOT . "/app/View/admin/contact.php";
}
$content = ob_get_clean();
require ROOT . "/app/View/template/default.php";