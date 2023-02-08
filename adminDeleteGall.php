<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

require_once "./Include/pdo.php";
$pdo = getPDO();

// DELETE THE GALLERY WHERE THE ID IS GET[ID]
$pdo->query("DELETE FROM GALLERIES WHERE id_gall = $_GET[id]");
$_SESSION['flash']['success'] = "Votre galerie a bien été supprimée";
header('Location: adminPanel.php');
die();