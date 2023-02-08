<?php
require_once './Functions/generalFunction.php';
require_once './Include/pdo.php';

if (!empty($_POST) && !empty($_POST['email'])) {
    $pdo = getPDO();
    $req = $pdo->prepare('SELECT * FROM USERS WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    session_start();
    if ($user) {
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE USERS SET reset_token = ?, reset_at = NOW() WHERE id_user = ?')->execute([$reset_token, $user['ID_USER']]);
        $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyées par emails';

        // TEST CODE WITHOUT SENDING EMAIL
        // $linkReset = "http://klaphoto1/reset.php?id={$user['ID_USER']}&token=$reset_token";
        // $successes['linkReset'] = "Cliquez <a href='{$linkReset}'>ICI</a>pour réinitialiser votre mot de passe";

        // CODE TO SEND THE LINK BY EMAIL
        mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://c2p.alwaysdata.net/reset.php?id={$user['ID_USER']}&token=$reset_token");
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
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