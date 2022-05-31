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
            <a href="index.php?p=adminPanel">Espace admin</a>
        <?php endif; ?>
    </div>
</div>