<?php
$user_id = $_GET['id'];
$token = $_GET['token'];

require_once "./Include/pdo.php";
$pdo = getPDO();

$req = $pdo->prepare('SELECT * FROM USERS WHERE id_user = ?');
$req->execute([$user_id]);
$user = $req->fetch();

session_start();

if ($user && $user['CONFIRMATION_TOKEN'] == $token) {
    $pdo->prepare('UPDATE USERS SET CONFIRMATION_TOKEN = NULL, confirmed_at = NOW() WHERE id_user = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
    $_SESSION['auth'] = $user;
    header('Location: account.php');
} else {
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: register.php');
}