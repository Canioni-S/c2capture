<?php
if (isset($_GET['id']) && isset($_GET['token'])) {
    require_once './Include/pdo.php';
    $pdo = getPDO();
    $req = $pdo->prepare('SELECT * FROM USERS WHERE id_user = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    if ($user) {
        if (!empty($_POST)) {
            if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE USERS SET password = ?, reset_at = NULL, reset_token = NULL WHERE id_user = ?')->execute([$password, $_GET['id']]);
                session_start();
                $_SESSION['flash']['success'] = 'Votre mot de passe a bien été modifié';
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }
        }
    } else {
        session_start();
        $_SESSION['flash']['error'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>


<!-- PASSWORD RESET VIEW -->
<?php
$title = 'Reset du mot de passe';
$extraCss = 'form';
?>

<?php require_once './Include/navbar.php' ?>

<div class="formPageContainer">
    <h1>Réinitialiser mon mot de passe</h1>

    <form class="form" action="" method="POST">
        
        <div class="formItem">
            <label class="formItem" for="">Mot de passe</label>
            <input type="password" name="password" class="formInput" />
        </div>

        <div class="formItem">
            <label class="formItem" for="">Confirmation du mot de passe</label>
            <input type="password" name="password_confirm" class="formInput" />
        </div>

        <button type="submit" class="formBtn">Réinitialiser votre mot de passe</button>
    </form>
</div>

<?php require './Include/footer.php'; ?>