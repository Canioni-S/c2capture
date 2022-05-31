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