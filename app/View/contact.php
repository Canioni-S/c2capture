<?php
if (!empty($_POST)) {
    $to = 'psycylinemontreal@gmail.com';
    $subject = 'Demande de prestation, ' . $_POST['prestation'];
    $message = "<html>
                    <h2>Email reçu de la part de</h2><br>
                    <h3>" . $_POST['firstname'] . " " . $_POST['lastname'] . "</h3><br>
                    <p>Contenu du message :<br>" . $_POST['description'] . "</p>";
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: ' . $_POST['email'];

    $retour = mail($to, $subject, $message, implode("\r\n", $headers));

    if ($retour)
        $_SESSION['flash']['success'] = 'Votre message à bien été envoyé';
    header('Location: contact.php');
    exit();
}
?>
<?php
$title = "Contact";
$extraCss = "form";
?>

<div class="formPageContainer">
    <div class="formPage">

        <form class="form" method="POST">
            <h1>Formulez votre demande</h1>

            <div class="formItem">
                <label for="prestation">Prestation</label>
                <select id="prestation" name="prestation" class="formInput" required>
                    <option value="">Veuillez selectionner une prestation</option>
                    <option value="reportage">Reportage</option>
                    <option value="authorPic">Photographie d'Auteur</option>
                    <option value="corporate">Corporate</option>
                    <option value="socialPic">Photographie Sociale</option>
                    <option value="autre">Autre (decrivez votre demande en bas du formulaire)</option>
                </select>
            </div>

            <div class="formItem">
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" class="formInput" required>
            </div>

            <div class="formItem">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" class="formInput" required>
            </div>

            <div class="formItem">
                <label for="email">Adresse email sur laquelle vous shouaitez être contacté</label>
                <input type="email" name="email" class="formInput" required>
            </div>

            <div class="formItem">
                <label for="description">Description de la collection</label>
                <textarea rows="5" cols="50" name="description" class="formInput"></textarea>
            </div>

            <button type="submit" class="formBtn">Envoyer la demande</button>

        </form>

    </div>
</div>