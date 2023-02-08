<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

require_once "./Include/pdo.php";
$pdo = getPDO();

// DELETE THE PICTURE WHERE THE ID IS GET[ID] AND SEND TO THE CURRENT GALLERY EDIT PAGE
$pdo->query("DELETE FROM PICTURES WHERE id_pic = $_GET[id_pic]");
$_SESSION['flash']['success'] = "Votre photo a bien été supprimée";
header('Location: adminAddPic.php?id=' . $_GET['id_gall']);
die();