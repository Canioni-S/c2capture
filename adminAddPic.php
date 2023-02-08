<?php
require_once "./Functions/adminFunction.php";
// PAGE RESTRICTED ADMIN ONLY
adminOnly();

// FETCH THE CONTENT OF A COLLECTION TO ADD IN THE RIGHT TABLE
$gallery = getGallery(htmlentities($_GET['id']));
// PEUT ETRE RECUPERER UNIQUEMENT L'ID

// FETCH THE CONTENT OF A GALLERY (PICTURES) TO USE THE GALERY'S INFORMATIONS IN THE VIEW
$pictures = getAllPicByGall($gallery[0]);

if (!empty($_POST)) {

    $id_gall = $gallery[0];
    $name_pic = htmlentities($_POST['name_pic']);
    $link_pic = htmlentities($_POST['link_pic']);

    if (empty($name_pic) or (empty($link_pic))) {
        $_SESSION['flash']['danger'] = "Tout les champs doivent etre remplis";
    } else {

        // ADD THE PICTURE TO THE TABLE PICTURES
        $pdo = getPDO();
        $req = $pdo->prepare("INSERT INTO PICTURES SET id_gall = ? , name_pic = ?, link_pic = ?, added_at = NOW()");
        $req->execute([$id_gall, $name_pic, $link_pic]);

        // SUCCESS MESSAGE AND REDIRECTION 
        $_SESSION['flash']['success'] = "Votre photo a bien été ajoutée";
        header('Location: adminAddPic.php?id=' . $id_gall);
    }
}

?>

<!-- ADD PICTURE VIEW -->
<?php
$title = "Page ajout de photo";
$extraCss = "admin";

?>

<?php require_once './Include/navbar.php'; ?>

<div class="adminPageContainer">

    <!-- FORM TO ADD A PICTURE TO THE CURRENT GALLERY -->
    <div class="adminPage">

        <h1>AJOUT DE PHOTO</h1>
        <h2>(Galerie : '<?= $gallery[2]; ?>')</h2>
        <form class="adminForm" action="" method="POST">

            <div class="adminItemView">
                <label for="name_pic">Nom de la photo</label>
                <input type="text" name="name_pic" class="adminInput">
            </div>

            <div class="adminItemView">
                <label for="link_pic">Link de la photo</label>
                <input type="text" name="link_pic" class="adminInput">
            </div>
            <div class="adminItemView BtnView">
                <button type="submit" class="adminBtn adminLink add">
                    <i class="icon bi bi-plus"></i><i class="icon bi bi-images"></i>
                </button>
            </div>

            <div class="goBackAdminPanel">
                <a href="./adminPanel.php"><i class="bi bi-box-arrow-in-left"></i>Retourner au panneau d'administration</a>
            </div>
        </form>
    </div>

    <!-- PREVIEW OF THE GALLERY OF PICTURES -->

    <?php if (!empty($pictures)) : ?>
        <div class="contentCollPreview">
            <h1>Aperçu de la collection :</h1>
            <div class="allCardContainer">
                <?php foreach ($pictures as $picture) : ?>
                    <div class="card">
                        <div class="imgContainer">
                            <img class="img" src="<?= $picture[3]; ?>" alt="<?= $picture[2]; ?>">
                        </div>
                        <div class="spanGrp">
                            <span class="imgTitle"><?= $picture[2] ?></span>
                            <div class="adminBtnGrp">
                                <button class="adminBtn edit">
                                    <a class="adminLink" href='./adminEditPic.php?id_pic=<?= $picture[0] ?>&id_gall=<?= $gallery[0] ?>'><i class="icon bi bi-pencil"></i></a>
                                </button>
                                <button class="adminBtn delete" onclick="return confirm('Voulez vous vraiment supprimer cette photo ?')">
                                    <a class="adminLink" href='./adminDeletePic.php?id_pic=<?= $picture[0] ?>&id_gall=<?= $gallery[0] ?>'><i class="icon deletee bi bi-trash"></i></a>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif ?>
</div>


<?php require './Include/footer.php'; ?>