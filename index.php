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
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>BOUGER + / MANGER +</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Style Page 2 -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina|Nunito" rel="stylesheet">

</head>
<body>
<header>
    <div class="jumbotron">
        <h1>Bougez +
            <small>pour manger +</small>
        </h1>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-4">
            <h3>Quel produit recherchez-vous ?</h3>
            <p class="erreur"><?php echo $erreur; ?></p>
            <form method="post" action="index.php">
                <div class="form-group">
                    <input type="text" name="produit" class="form-control" id="produit" placeholder="Entrer la catégorie de produits"
                           value="<?php echo $produit; ?>"/>
                </div>
                <input class="btn btn-default" type="reset" name="btnReset" value="Annuler"/>
                <input class="btn btn-success" type="submit" name="btnSubmit" value="Valider"/>
            </form>
        </div>
    </div>
</div>

</body>
</html>
