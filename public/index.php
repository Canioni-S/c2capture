<?php

use App\Controller\CollectionController;
use App\App;

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
    // require ROOT . "/app/View/blog/home.php";
} elseif ($page === 'collection') {
    $controller = new CollectionController();
    $controller->showCollection();
    // require ROOT . "/app/View/blog/collection.php";
} elseif ($page === 'gallery') {
    $controller = new CollectionController();
    $controller->showGallery();
    // require ROOT . "/app/View/blog/gallery.php";
}
// // PERSONAL INFOS
// elseif ($page === 'prestation') {
//     require ROOT . "/app/View/prestation.php";
// } elseif ($page === 'aboutMe') {
//     require ROOT . "/app/View/aboutMe.php";
// } elseif ($page === 'contact') {
//     require ROOT . "/app/View/contact.php";
// }
// // USERS 
// elseif ($page === 'login') {
//     require ROOT . "/app/View/user/login.php";
// } elseif ($page === 'register') {
//     require ROOT . "/app/View/user/register.php";
// }  elseif ($page === 'confirm') {
//     require ROOT . "/app/View/user/confirm.php";
// } elseif ($page === 'forget') {
//     require ROOT . "/app/View/user/forget.php";
// } elseif ($page === 'reset') {
//     require ROOT . "/app/View/user/reset.php";
// }  elseif ($page === 'logout') {
//     require ROOT . "/app/View/user/logout.php";
// } elseif ($page === 'account') {
//     require ROOT . "/app/View/user/account.php";
// }
// // ADMIN
// elseif ($page === 'adminPanel') {
//     require ROOT . "/app/View/admin/adminPanel.php";
// }