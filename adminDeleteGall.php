<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

$id_gall = htmlentities($_GET['id']);

require_once "./Include/pdo.php";
$pdo = getPDO();

// DELETE THE GALLERY WHERE THE ID IS GET[ID]
$req = $pdo->prepare("DELETE FROM GALLERIES WHERE id_gall = ?");
$req->execute([$id_gall]);

$_SESSION['flash']['success'] = "Votre galerie a bien été supprimée";
header('Location: adminPanel.php');
die();