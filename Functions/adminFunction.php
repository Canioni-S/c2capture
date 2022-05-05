<?php
require_once "./Include/pdo.php";

function adminOnly()
{
    // if (session_status() == PHP_SESSION_NONE) {
    //     session_start();
    // }
    if ($_SESSION['auth']['ROLE'] != 'admin') {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: login.php');
        exit();
    }
}

function getCollection($id_coll)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM COLLECTIONS WHERE id_coll = ?");
    $req->execute([$id_coll]);
    $result = $req->fetch();
    return $result;
}

function getAllCollections()
{
    $pdo = getPDO();
    $req = $pdo->query("SELECT * FROM COLLECTIONS ORDER BY name_coll")->fetchAll();
    return $req;
}

function getGallery($id_gall)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM GALLERIES WHERE id_gall = ?");
    $req->execute([$id_gall]);
    $result = $req->fetch();
    return $result;
}

function getAllGalleries()
{
    $pdo = getPDO();
    $req = $pdo->query("SELECT * FROM GALLERIES")->fetchAll();
    return $req;
}

function getAllGallByColl($id_coll)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM GALLERIES WHERE id_coll = ? ORDER BY name_gall");
    $req->execute([$id_coll]);
    $result = $req->fetchAll();
    return $result;
}

function getFirstGallbyColl($id_coll)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM GALLERIES WHERE id_coll = ? ORDER BY name_gall LIMIT 1");
    $req->execute([$id_coll]);
    $result = $req->fetch();
    return $result;
}

function getPicture($id_pic)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM PICTURES WHERE id_pic = ?");
    $req->execute([$id_pic]);
    $result = $req->fetch();
    return $result;
}

function getAllPicByGall($id_gall)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM PICTURES WHERE id_gall = ? ORDER BY added_at DESC");
    $req->execute([$id_gall]);
    $result = $req->fetchAll();
    return $result;
}

function getFirstPicByGall($id_gall)
{
    $pdo = getPDO();
    $req = $pdo->prepare("SELECT * FROM PICTURES WHERE id_gall = ? ORDER BY added_at DESC LIMIT 1");
    $req->execute([$id_gall]);
    $result = $req->fetch();
    return $result;
}
