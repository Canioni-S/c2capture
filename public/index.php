<?php

use App\App;
use App\Controller\BlogController;
use App\Controller\UserController;
use App\Controller\CollectionController;

define('ROOT', dirname(__DIR__));

require ROOT . "/app/App.php";
App::load();

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'home';
}

// BLOG
if ($page === 'home') {
    $controller = new CollectionController();
    $controller->index();
} elseif ($page === 'collection') {
    $controller = new CollectionController();
    $controller->showCollection();
} elseif ($page === 'gallery') {
    $controller = new CollectionController();
    $controller->showGallery();
} elseif ($page === 'aboutMe') {
    $controller = new BlogController();
    $controller->aboutMe();
} elseif ($page === 'contact') {
    $controller = new BlogController();
    $controller->contact();
} elseif ($page === 'legalMention') {
    $controller = new BlogController();
    $controller->legalMention();
} elseif ($page === 'prestation') {
    $controller = new BlogController();
    $controller->prestation();
}

// USERS 
elseif ($page === 'login') {
    $controller = new UserController();
    $controller->login();
} elseif ($page === 'register') {
    $controller = new UserController();
    $controller->register();
} elseif ($page === 'confirm') {
    $controller = new UserController();
    $controller->confirm();
} elseif ($page === 'forget') {
    $controller = new UserController();
    $controller->forget();
} elseif ($page === 'reset') {
    $controller = new UserController();
    $controller->reset();
} elseif ($page === 'logout') {
    $controller = new UserController();
    $controller->logout();
} elseif ($page === 'account') {
    $controller = new UserController();
    $controller->account();
}

// // ADMIN
// elseif ($page === 'adminPanel') {
//     require ROOT . "/app/View/admin/adminPanel.php";
// }