<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

// PROCESS THE POST VALUE RECEIVED AND ADD THE NEW OCCURENCE TO TABLE COLLECTIONS
if (!empty($_POST)) {

    $name_coll = htmlentities($_POST['name_coll']);
    $description_coll = htmlentities($_POST['description_coll']);

    if (empty($name_coll) or empty($description_coll)) {
        $_SESSION['flash']['danger'] = "Tout les champs doivent etre remplis";
    } else {
        $pdo = getPDO();
        $req = $pdo->prepare("INSERT INTO COLLECTIONS SET name_coll = ?, description_coll = ?");
        $req->execute([$name_coll, $description_coll]);
        $_SESSION['flash']['success'] = "Votre collection a bien été ajoutée";
        header('Location: adminPanel.php');
        die();
    }
}
?>



<!-- ADD COLLECTION VIEW -->
<?php
$title = "Page ajout de collection";
$extraCss = "admin";

?>

<?php require_once './Include/navbar.php'; ?>

<div class="adminPageContainer">
    <!-- FORM TO ADD A NEW COLLECTION -->
    <div class="adminPage">

        <h1>AJOUTER UNE COLLECTION</h1>
        <p>Choisissez un nom et une description pour votre nouvelle collection</p>

        <form class="adminForm" action="" method="POST">

            <div class="adminItemView">
                <label for="name_coll">Entrez le nom de la nouvelle collection</label>
                <input type="text" name="name_coll" class="adminInput">
            </div>

            <div class="adminItemView">
                <label for="description_coll">Entrez la description de la nouvelle collection</label>
                <textarea rows="5" cols="50" name="description_coll" class="adminInput"></textarea>
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