<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

// FETCH THE CONTENT OF A GALERY (PICTURES) TO USE THE GALERY'S INFORMATIONS IN THE VIEW
$id_gall = htmlentities($_GET['id']);

if (!empty($id_gall)) {
 $gallery = getGallery($id_gall);
}

// PROCESS THE POST VALUE RECEIVED AND UPDATE THE CORRESPONDING TABLE GALLERIES OCCURENCE
if (!empty($_POST)) {

    $name_gall = htmlentities($_POST['name_gall']);
    $description_gall = htmlentities($_POST['description_gall']);
    $id_gall = htmlentities($_GET['id']);

    if (empty($name_gall) or empty($description_gall)) {
        $_SESSION['flash']['danger'] = "Tout les champs doivent etre remplis";
    } else {
        $pdo = getPDO();
        $req = $pdo->prepare("UPDATE GALLERIES SET name_gall = ?, description_gall = ? WHERE id_gall = ?");
        $req->execute([$name_gall, $description_gall, $id_gall]);
        $_SESSION['flash']['success'] = "Votre galerie a bien été modifiée";
        header('Location: adminPanel.php');
        die();
    }
}
?>

<!-- EDIT GALLERY VIEW -->
<?php
$title = "Page edition galerie";
$extraCss = "admin";

?>

<?php require_once './Include/navbar.php'; ?>
<div class="adminPageContainer">
    <div class="adminPage">

        <h1>MODIFIER LA GALERIE "<?= $gallery[2] ?>"</h1>
        <p>Choisissez un nouveau nom et description pour votre galerie</p>

        <form class="adminForm" action="" method="post">

            <div class="adminItemView">
                <label for="name_gall">Nouveau nom de la galerie</label>
                <input type="text" name="name_gall" class="adminInput" value="<?= $gallery[2] ?>">
            </div>

            <div class="adminItemView">
                <label for="description_gall">Nouvelle description de la galerie</label>
                <textarea rows="5" cols="50" name="description_gall" class="adminInput"><?= $gallery[3]; ?></textarea>
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