<?php
require_once "./Include/myAutoloader.php";
$auth = App::getAuth();
$db = App::getDB();
$auth->connectFromCookie($db);


if ($auth->user()) {
    App::redirect("account.php");
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
    $session = Session::getInstance();

    if ($user) {
        $session->setFlash("success", "Vous êtes maintenant connecté");
        if ($_SESSION['auth']['ROLE'] == 'admin') {
            App::redirect("adminPanel.php");
        } else {
            App::redirect("account.php");
        }
    } else {
        $session->setFlash("danger", "Identifiant ou mot de passe incorrecte");
    }
}

?>

<!-- LOGIN VIEW -->
<?php
$title = "Se connecter";
$extraCss = "form";
?>

<?php require_once './Include/navbar.php'; ?>

<div class="formPageContainer">
    <div class="formPage">
        <h1>Se connecter</h1>

        <?php require_once './Include/alertBoxes.php'; ?>

        <form class="form" action="" method="POST">

            <div class="formItem">
                <label for="username">Entrez votre pseudo ou email</label>
                <input type="text" name="username" class="formInput" required>
            </div>

            <div class="formItem">
                <label for="password">Entrez votre Mot de passe <br><a href="forget.php">(J'ai oublié mon mot de passe)</a></label>
                <input type="password" name="password" class="formInput" required>
            </div>

            <button type="submit" class="formBtn">Je me connecte</button>
            <div class="formItem">
                <label>
                    <input type="checkbox" name="remember" value="1" /> Se souvenir de moi
                </label>
            </div>
            <a href="./register.php">Je n'ai pas de compte</a>


        </form>
    </div>
</div>

<?php require_once './Include/footer.php'; ?>