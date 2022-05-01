<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

// FETCH THE CONTENT OF A PICTURE (NAME AND LINK) TO USE DYNAMICALLY IN THE VIEW
if (!empty($_GET['id_pic']) and !empty($_GET['id_coll'])) {
    $pdo = getPDO();
    $id_pic = htmlentities($_GET['id_pic']);
    $picture = $pdo->query("SELECT * FROM pictures WHERE id_pic = $id_pic")->fetch();
}

// PROCESS THE POST VALUE RECEIVED AND UPDATE THE CORRESPONDING TABLE PICTURES OCCURENCE
if (!empty($_POST)) {

    $name_pic = htmlentities($_POST['name_pic']);
    $link_pic = htmlentities($_POST['link_pic']);
    $id_coll = htmlentities($_GET['id_coll']);

    if (empty($name_pic) or empty($link_pic)) {
        $_SESSION['flash']['danger'] = "Tout les champs doivent etre remplis";
    } else {
        $pdo = getPDO();
        $req = $pdo->prepare("UPDATE PICTURES SET name_pic = ?, link_pic = ? WHERE id_pic = ?");
        $req->execute([$name_pic, $link_pic, $id_pic]);
        $_SESSION['flash']['success'] = "Votre photo a bien été modifiée";
        header('Location: adminAddPic.php?id=' . $id_coll);
        die();
    }
}
?>

<!-- EDIT PICTURE VIEW -->
<?php
$title = "Page edition de photo";
$extraCss = "admin";

?>

<?php require_once './Include/navbar.php'; ?>
<div class="adminPageContainer">
    <div class="adminPage">
<?=     var_dump($_GET); ?>
        <h1>MODIFIER LA PHOTO "<?= $picture[2] ?>"</h1>
        <p>Choisissez un nouveau nom et/ou lien pour votre photo</p>

        <form class="adminForm" action="" method="post">

            <div class="adminItemView">
                <label for="name_pic">Nouveau nom de la photo</label>
                <input type="text" name="name_pic" class="adminInput" value="<?= $picture[2] ?>">
            </div>

            <div class="adminItemView">
                <label for="link_pic">Nouveau lien de la photo</label>
                <input type="text" name="link_pic" class="adminInput" value="<?= $picture[3]; ?>">
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