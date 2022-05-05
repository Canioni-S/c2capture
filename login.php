<?php
require_once './Functions/registrationFunction.php';
require_once './Functions/generalFunction.php';
require_once "./Include/myAutoloader.php";


reconnect_from_cookie();

if (isset($_SESSION['auth'])) {
    header('Location: account.php');
    exit();
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    
    require_once "./Include/pdo.php";

    $pdo = getPDO();
    $req = $pdo->prepare('SELECT * FROM USERS WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();

    if (password_verify($_POST['password'], $user['PASSWORD'])) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
        if ($_POST['remember']) {
            $remember_token = str_random(250);
            $pdo->prepare('UPDATE USERS SET remember_token = ? WHERE id_user = ?')->execute([$remember_token, $user['ID_USER']]);
            setcookie('remember', $user['ID_USER'] . '==' . $remember_token . sha1($user['ID_USER'] . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
        }
        if ($_SESSION['auth']['ROLE'] == 'admin') {
            header('Location: adminPanel.php');
            exit();
        } else {
            header('Location: account.php');
            exit();
        }
    } else {
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
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