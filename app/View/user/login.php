<div class="formPageContainer">
    <div class="formPage">

        <h1>Se connecter</h1>

        <form class="form" action="" method="POST">

            <div class="formItem">
                <label for="username">Entrez votre pseudo ou email</label>
                <input type="text" name="username" class="formInput" required>
            </div>

            <div class="formItem">
                <label for="password">Entrez votre Mot de passe <br><a href="index.php?p=forget">(J'ai oublié mon mot de passe)</a></label>
                <input type="password" name="password" class="formInput" required>
            </div>

            <button type="submit" class="formBtn">Je me connecte</button>

            <div class="formItem">
                <label>
                    <input type="checkbox" name="remember" value="1" /> Se souvenir de moi
                </label>
            </div>

            <a href="index.php?p=register">Je n'ai pas de compte</a>

        </form>
    </div>
</div>