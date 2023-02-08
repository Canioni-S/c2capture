<?php
require_once "./Functions/generalFunction.php";
session_start();
if (!empty($_POST)) {

    $errors = array();

    require_once "./Include/pdo.php";
    $pdo = getPDO();

    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);

    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumérique)";
    } else {
        $req = $pdo->prepare('SELECT id_user FROM USERS WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if ($user) {
            $errors['username'] = 'Ce pseudo est déjà pris';
        }
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT id_user FROM USERS WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if ($user) {
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }

    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }

    if (empty($errors)) {

        $req = $pdo->prepare("INSERT INTO USERS SET username = ?, password = ?, email = ?, role = 'visiteur', confirmation_token = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
        $user_id = $pdo->lastInsertId();

        // TEST CODE WITHOUT SENDING THE EMAIL
        // $linkValidation = "http://klaphoto1/confirm.php?id=$user_id&token=$token";
        // $successes['linkValidation'] = "<a href='{$linkValidation}'>Afin de valider votre compte merci de cliquer sur ce lien</a>";

        // CODE TO SEND THE VERIFICATION BY EMAIL
        $to = $_POST['email'];
        $subject = "Confirmation de votre compte";
        $message = "<html>
                        <h2>Merci d'avoir créer un compte</h2><br>
                        <p>Afin de valider votre compte merci de cliquer sur ce lien</p><br>
                        <a href='http://c2capture.fr/confirm.php?id=$user_id&token=$token'>Confirmez votre compte</a><br>
                    </html>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: c2p.alwaysdata@gmail.com';

        $retour = mail($to, $subject, $message, implode("\r\n", $headers));

        if ($retour)
            $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location: login.php');
        exit();
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