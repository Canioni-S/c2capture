<?php
require_once './Include/myAutoloader.php';

if (!empty($_POST) && !empty($_POST['email'])) {
    $db = App::getDB();
    $auth = App::getAuth();
    $session = Session::getInstance();
    if($auth->resetPassword($db, $_POST['email'])){
        $session->setFlash("success", "Les instructions du rappel de mot de passe vous ont été envoyées par emails");
        App::redirect("login.php");
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

<?php require_once './Include/navbar.php'; ?>

<div class="formPageContainer">
    <div class="formPage">
        <?php require_once './Include/alertBoxes.php'; ?>

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

<?php require_once './Include/footer.php'; ?>