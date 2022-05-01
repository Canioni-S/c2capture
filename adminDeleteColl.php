<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

$id_coll = htmlentities($_GET['id']);
var_dump($id_coll);

require_once "./Include/pdo.php";
$pdo = getPDO();

// DELETE THE COLLECTION AND GALLERIES WHERE THE ID IS GET[ID]
$req = $pdo->prepare("DELETE FROM COLLECTIONS WHERE id_coll = ?");
$req->execute([$id_coll]);

$req = $pdo->prepare("DELETE FROM GALLERIES WHERE id_coll = ?");
$req->execute([$id_coll]);

$_SESSION['flash']['success'] = "Votre collection a bien été supprimée";
header('Location: adminPanel.php');
die();
