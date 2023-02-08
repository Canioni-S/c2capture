<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

// FETCH THE CONTENT OF A COLLECTION
$collection = getCollection(htmlentities($_GET['id']));

if (!empty($_POST)) {


    $id_coll = htmlentities($_GET['id']);
    $name_gall = htmlentities($_POST['name_gall']);
    $description_gall = htmlentities($_POST['description_gall']);

    if (empty($name_gall) or (empty($description_gall))) {
        $_SESSION['flash']['danger'] = "Tout les champs doivent etre remplis";
    } else {
        $pdo = getPDO();
        $req = $pdo->prepare("INSERT INTO GALLERIES SET id_coll = ? , name_gall = ?, description_gall = ?, created_at = NOW()");
        $req->execute([$id_coll, $name_gall, $description_gall]);
        $_SESSION['flash']['success'] = "Votre galerie a bien été ajoutée";
        header('Location: adminPanel.php');
        die();
    }
}
?>



<!-- ADD GALERY VIEW -->
<?php
$title = "Page ajout de galerie";
$extraCss = "admin";

?>

<?php require_once './Include/navbar.php'; ?>

<div class="adminPageContainer">
    <!-- FORM TO ADD A GALLERY TO THE CURRENT COLLECTION -->
    <div class="adminPage">

        <h1>AJOUTER UNE GALERIE</h1>
        <h2>(Collection : '<?= $collection[1]; ?>')</h2>
        <p>Choisissez un nom et une description pour votre nouvelle galerie</p>

        <form class="adminForm" action="" method="POST">


            <div class="adminItemView">
                <label for="name_gall">Nom de la galerie</label>
                <input type="text" name="name_gall" class="adminInput">
            </div>

            <div class="adminItemView">
                <label for="description_gall">Description de la galerie</label>
                <textarea rows="5" cols="50" name="description_gall" class="adminInput"></textarea>
            </div>

            <div class="adminItemView BtnView">
                <button type="submit" class="adminBtn adminLink add">
                    <i class="icon bi bi-check-lg">Valider</i>
                </button>
            </div>

            <div class="goBackAdminPanel">
                <a href="./adminPanel.php"><i class="bi bi-box-arrow-in-left"></i>Retourner au panneau d'administration</a>
            </div>
        </form>
    </div>
</div>
<?php require './Include/footer.php'; ?>