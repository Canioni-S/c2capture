<?php
// $auth = App::getAuth();
// $db = App::getDB();
// $auth->connectFromCookie($db);


// if ($auth->user()) {
//     App::redirect("account.php");
// }

use App\App;
use App\DBAuth;
use App\Session;

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $session = Session::getInstance();
    $auth = new DBAuth(Session::getInstance());
    $user = $auth->login($_POST['username'], $_POST['password'], isset($_POST['remember']));

    if ($user) {
        $session->setFlash("success", "Vous êtes maintenant connecté");
        if ($user->ROLE == 'admin') {
            App::redirect("index.php?p=adminPanel");
        } else {
            App::redirect("index.php?p=account");
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


<div class="formPageContainer">
    <div class="formPage">
        <h1>Se connecter</h1>

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