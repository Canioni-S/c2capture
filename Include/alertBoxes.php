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