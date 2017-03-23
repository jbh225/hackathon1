<?php
if (isset($_POST['btnSubmit'])) {
    // --- le formulaire a été rempli
    // --- recuperation des donnees
    $produit = trim($_POST['produit']);
    if ($produit == '') {
        // --- le champ produit est vide
        $erreur = 'Merci d\'indiquer un type de produit.';
    } else {
        // --- tentative de recuperation de la liste des produits via l'api open food facts
        $repapi = file_get_contents('https://fr-en.openfoodfacts.org/category/' . $produit . '.json');
        // --- decodage des infos recuperees
        $page = json_decode($repapi);
        // --- nombre de produits disponibles
        $nbprod = $page->count;
        if ($nbprod == 0) {
            $erreur = 'Ce type de produit ne retourne aucun résultat. Tentez une autre formulation.';
        } else {
            // --- on a recupere des trucs, il va falloir les affiche
            // --- nombre de produits par page
            $pagesize = $page->page_size;
            $nbpages = ceil($nbprod / $pagesize);
            header('location:products.php?produit=' . $produit . '&nbprod=' . $nbprod . '&nbpages=' . $nbpages);
        }
    }
} else {
    $produit = '';
    $erreur = '&nbsp;';
}
?>

<!DOCTYPE html>
<html lang="Fr">
<head>
    <meta charset="utf-8">
    <title>Bien manger c'est important</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
    <title>Bien manger c'est important</title>
</head>
<body>

<header>
    <div class="jumbotron">

    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>Vous recherchez un produit?</h1>
            <p class="erreur"><?php echo $erreur; ?></p>
            <form method="post" action="index.php">
                <div class="form-group">
                    <input type="text" name="produit" class="form-control" id="produit" placeholder="Type de produit"
                           value="<?php echo $produit; ?>"/>
                </div>
                <input class="btn btn-default" type="reset" name="btnReset" value="Effacer"/>
                <input class="btn btn-success" type="submit" name="btnSubmit" value="Envoyer"/>
            </form>
        </div>
    </div>
</div>

</body>
</html>
