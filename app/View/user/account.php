<?php

use App\App;

App::getAuth()->restrict();

// PROCESS FORM POST AND CHANGE PASSWORD
if (!empty($_POST)) {
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
    } else {
        $user_id = $_SESSION['auth']->ID_USER;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        App::getInstance()->getTable("USERS")->editPass($password, $user_id);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
}
?>


<!-- ACCOUNT VIEW -->
<?php
$title = 'Mon compte';
$extraCss = 'form';
?>

<div class="formPageContainer">
    <div class="formPage">
        <h1>MON COMPTE</h1>
        <h1>Bonjour <?= $_SESSION['auth']->ROLE, " ", $_SESSION['auth']->USERNAME; ?></h1>

        <form class="form" action="" method="post">

            <div class="formItem">
                <label for="password">Choisissez votre nouveau mot de passe</label>
                <input type="password" name="password" class="formInput">
            </div>
            <div class="formItem">
                <label for="password_confirm">Confirmez votre nouveau mot de passe</label>
                <input type="password" name="password_confirm" class="formInput">
            </div>

            <button class="formBtn">Changer mon mot de passe</button>
        </form>
        <?php
        if (isset($_SESSION['auth']) and $_SESSION['auth']->ROLE == 'admin') : ?>
            <a href="./adminPanel.php">Espace admin</a>
        <?php endif; ?>
    </div>
</div>