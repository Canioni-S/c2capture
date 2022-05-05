<?php

require_once "./Include/myAutoloader.php";

if (!empty($_POST)) {

    $errors = array();

    $db = App::getDB();

    $validator = new Validator($_POST);

    $validator->isAlphaNum('username', "Votre pseudo n'est pas valide (alphanumérique)");

    if ($validator->isValid()) {
        $validator->isUniq('username', $db, 'USERS', "Ce pseudo est déjà pris");
    }

    $validator->isEmail('email', "Votre email n'est pas valide");

    if ($validator->isValid()) {
        $validator->isUniq('email', $db, 'USERS', "Cet email est déjà utilisé pour un autre compte");
    }

    $validator->isConfirmed('password', "Vous devez rentrer un mot de passe valide");

    if ($validator->isValid()) {

        $auth = new Auth($db);
        $auth->register($_POST['username'], $_POST['password'], $_POST['email']);
        Session::getInstance()->setFlash('success', "Un email de confirmation vous a été envoyé pour valider votre compte");
        App::redirect("login.php");
    } else {
        $errors = $validator->getErrors();
    }
}
?>

<!-- REGISTER VIEW -->
<?php
$title = "S'inscrire";
$extraCss = "form";

?>

<?php require_once './Include/navbar.php'; ?>

<div class="formPageContainer">
    <div class="formPage">
        <h1>S'inscrire</h1>

        <?php require_once "./Include/alertBoxes.php" ?>

        <form class="form" method="POST">
            <div class="formItem">
                <label for="username">Choisissez votre nom d'utilisateur</label>
                <input type="text" name="username" class="formInput">
            </div>

            <div class="formItem">
                <label for="email">Entrez votre adresse email</label>
                <input type="email" name="email" class="formInput">
            </div>

            <div class="formItem">
                <label for="password">Choisissez votre Mot de passe</label>
                <input type="password" name="password" class="formInput">
            </div>

            <div class="formItem">
                <label for="password_confirm">Merci de confirmer votre Mot de passe</label>
                <input type="password" name="password_confirm" class="formInput">
            </div>

            <button type="submit" class="formBtn">Je crée mon compte</button>
        </form>
    </div>
</div>

<?php require './Include/footer.php'; ?>