<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

// FETCH THE CONTENT OF A COLLECTION TO ADD IN THE RIGHT TABLE
$id_coll = htmlentities($_GET['id']);
$collection = getCollection($id_coll);

if (!empty($_POST)) {

    $name_coll = htmlentities($_POST['name_coll']);
    $description_coll = htmlentities($_POST['description_coll']);
    $id_coll = htmlentities($_GET['id']);

    if (empty($name_coll) or empty($description_coll)) {
        $_SESSION['flash']['danger'] = "Tout les champs doivent etre remplis";
    } else {
        $pdo = getPDO();
        $req = $pdo->prepare("UPDATE COLLECTIONS SET name_coll = ?, description_coll = ? WHERE id_coll = ?");
        $req->execute([$name_coll, $description_coll, $id_coll]);
        $_SESSION['flash']['success'] = "Votre collection a bien été modifiée";
        header('Location: adminPanel.php');
        die();
    }
}
?>

<!-- EDIT COLLECTION VIEW -->
<?php
$title = "Page edition collection";
$extraCss = "admin";
?>

<?php require_once './Include/navbar.php'; ?>
<div class="adminPageContainer">
    <div class="adminPage">

        <h1>MODIFIER LA COLLECTION "<?= $collection[1] ?>"</h1>
        <p>Choisissez un nouveau nom et description pour votre collection</p>

        <form class="adminForm" action="" method="post">

            <div class="adminItemView">
                <label for="name_coll">Nouveau nom de la collection</label>
                <input type="text" name="name_coll" class="adminInput" value="<?= $collection[1] ?>">
            </div>

            <div class="adminItemView">
                <label for="description_coll">Nouvelle description de la collection</label>
                <textarea rows="5" cols="50" name="description_coll" class="adminInput"><?= $collection[2]; ?></textarea>
            </div>

            <div class="adminItemView BtnView">
                <button type="submit" class="adminBtn adminLink add">
                    <i class="icon bi bi-check-lg">Valider</i></button>
            </div>

            <div class="goBackAdminPanel">
                <a href="./adminPanel.php"><i class="bi bi-box-arrow-in-left"></i>Retourner au panneau d'administration</a>
            </div>
        </form>
    </div>
</div>
<?php require './Include/footer.php'; ?>