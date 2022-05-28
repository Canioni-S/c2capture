<?php

use App\App;
use App\Session;

if (!empty($_POST) && !empty($_POST['email'])) {
    $db = App::getInstance()->getDB();
    $auth = App::getAuth();
    $session = Session::getInstance();
    if ($auth->resetPassword($db, $_POST['email'])) {
        $session->setFlash("success", "Les instructions du rappel de mot de passe vous ont été envoyées par emails");
        App::redirect("index.php?p=login");
    } else {
        $session->setFlash("danger", "Aucun compte ne correspond a cet email");
    }
}
?>


<!-- FORGET VIEW -->
<?php

$title = 'Mot de passe oublié';
$extraCss = 'form';

?>


<div class="formPageContainer">
    <div class="formPage">

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

        <h1>Mot de passe oublié</h1>

        <form class="form" action="" method="POST">

            <div class="formItem">
                <label class="formItem" for="email">Entrez l'adresse email utilisé lors de la création de votre compte</label>
                <input type="email" name="email" class="formInput">
            </div>

            <button type="submit" class="formBtn">Valider</button>
        </form>
    </div>
</div>