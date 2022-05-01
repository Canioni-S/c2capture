<?php
require_once "./Include/pdo.php";

function adminOnly()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SESSION['auth']['ROLE'] != 'admin') {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: login.php');
        exit();
    }
}

function getCollection($id_coll)
{
    $pdo = getPDO();
    $req = $pdo->query("SELECT * FROM COLLECTIONS WHERE id_coll = $id_coll")->fetch();
    return $req;
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
    $req = $pdo->query("SELECT * FROM GALLERIES WHERE id_gall = $id_gall")->fetch();
    return $req;
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
    $req = $pdo->query("SELECT * FROM GALLERIES WHERE id_coll = $id_coll ORDER BY name_gall")->fetchAll();
    return $req;
}

function getFirstGallbyColl($id_coll)
{
    $pdo = getPDO();
    $req = $pdo->query("SELECT * FROM GALLERIES WHERE id_coll = $id_coll ORDER BY name_gall LIMIT 1")->fetch();
    return $req;
}

function getAllPicByGall($id_gall)
{
    $pdo = getPDO();
    $req = $pdo->query("SELECT * FROM PICTURES WHERE id_gall = $id_gall ORDER BY added_at DESC")->fetchAll();
    return $req;
}

function getFirstPicByGall($id_gall)
{
    $pdo = getPDO();
    $req = $pdo->query("SELECT * FROM PICTURES WHERE id_gall = $id_gall ORDER BY added_at DESC LIMIT 1")->fetch();
    return $req;
}

