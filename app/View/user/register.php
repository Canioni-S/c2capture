<?php

use App\App;
use App\Session;
use App\Validator;

if (!empty($_POST)) {

    $errors = array();

    $db = App::getInstance()->getDB();

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

        App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email']);
        Session::getInstance()->setFlash('success', "Un email de confirmation vous a été envoyé pour valider votre compte");
        App::redirect("index.php?p=login");
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

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <h3>Une erreur est survenue</h3>
        <br>
        <?php foreach ($errors as $error) : ?>
            <?= $error; ?>
            <br><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($successes)) : ?>
    <div class="alert alert-success">
        <h3>Opération bien effectuée</h3>
        <br>
        <?php foreach ($successes as $success) : ?>
            <?= $success; ?>
            <br><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="formPageContainer">
    <div class="formPage">
        <h1>S'inscrire</h1>

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