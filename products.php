<?php
if (isset($_GET['produit'])) $produit = $_GET['produit'];
if (isset($_GET['nbprod'])) $nbprod = $_GET['nbprod'];
if (isset($_GET['nbpages'])) $nbpages = $_GET['nbpages'];
if (isset($_GET['numpage'])) $numpage = $_GET['numpage'];
else $numpage = 1;

$rep = file_get_contents('https://fr-en.openfoodfacts.org/category/' . $produit . '/' . $numpage . '.json');
$page = json_decode($rep);
$products = $page->products;

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

<header>
    <div class="jumbotron">
        <h1>Bougez +
            <small>pour manger +</small>
        </h1>
    </div>
</header>

<div class="container">
    <div class="row">
        <span class="col-xs-12">

            <h2>
                <span class="retour">
                    <a href="index.php" button type="button" class="btn btn-default" aria-label="Left Align">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    </a>
                </span>
                &nbsp &nbsp

                Catégorie : <?php echo $produit; ?>
                &nbsp | &nbsp

                <?php echo $nbprod; ?> produits
                &nbsp | &nbsp

                page <?php echo $numpage . '/' . $nbpages; ?>
                &nbsp &nbsp

                <?php
                // --- preparation des boutons page precedente/suivante
                $avant = $apres = 'products.php?produit=' . $produit . '&nbprod=' . $nbprod . '&nbpages=' . $nbpages;
                $avant .= '&numpage=' . ($numpage - 1);
                $apres .= '&numpage=' . ($numpage + 1);
                if ($numpage > 1) {
                    echo '<a class="btn btn-default avant" href="' . $avant . '"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>';
                    echo '&nbsp;&nbsp;';
                }
                if ($numpage < $nbpages) {
                    echo '<a class="btn btn-default apres" href="' . $apres . '"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></a>';
                }
                ?>
            </h2>

    </div>


    <div class="row">

        <?php

        foreach ($products as $product) {
            $id = $product->id;
            $urlimg = 'images/noimg.jpg';
            if (property_exists($product, 'image_front_url')) $urlimg = $product->image_front_url;
            elseif (property_exists($product, 'image_front_small_url')) $urlimg = $product->image_front_small_url;
            elseif (property_exists($product, 'image_front_thumb_url')) $urlimg = $product->image_front_thumb_url;
            $name = '';
            if (property_exists($product, 'product_name_fr')) $name = $product->product_name_fr;
            elseif (property_exists($product, 'generic_name_fr')) $name = $product->generic_name_fr;
            echo '

                <div class="col-lg-3 text-center ">
                    <div class="thumbnail vignette">
                        <a class="txtfoot" data-toggle="modal" data-target="#'.$id.'">
                            <img class="miniature" src="' . $urlimg . '" alt="..." />
                        </a>
                        <div class="caption">
                            <h3>' . $name . '</h3>
                        </div>
                        <p>
            ';
            $nutrigrade = '';
            if (property_exists($product, 'nutrition_grades')) {
                $nutrigrade = $product->nutrition_grades;
                echo '<img class="nutrigrade" src="images/nutriscore-' . $nutrigrade . '.svg" />';
                echo '&nbsp;&nbsp;';
            }
            echo '
                            <a href="calories.php?id=' . $id . '" class="btn btn-default" role="button">Manger</a>
                        </p>
                    </div>
                    
                    <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3 class="modal-title" id="myModalLabel">'.$name.'</h3>
                                </div>
                                <div class="modal-body legal">
                                    <img class="xl-img" src="'.$urlimg.'" />
            ';
                                    // --- recuperation des infos produit
                                    $rep2 = file_get_contents('http://fr.openfoodfacts.org/api/v0/produit/' . $id . '.json');
                                    $infos2 = json_decode($rep2);
                                    $product2 = $infos2->product;
                                    $ingredients = 'Non précisé';
                                    if (property_exists($product2, 'ingredients_text')) $ingredients = $product->ingredients_text;
                                    echo '<br />';
                                    $kcal = 'Non précisée';
                                    if (property_exists($product2, 'nutriments')) {
                                        $energie = $product2->nutriments;
                                        if (property_exists($energie, 'energy')) {
                                            $kj = $energie->energy;
                                            $kcal = round($kj * 0.239, 0);
                                        }
                                    }
                                    echo '<h4>Ingrédients :</h4><p>'.$ingredients.'</p>';
                                    echo '<h4>';
                                    if ( $nutrigrade != '' ) {
                                        echo '<img class="nutrigrade" src="images/nutriscore-' . $nutrigrade . '.svg" />&nbsp;&nbsp;';
                                    }
            echo '
                                    Valeur énergétique : '.$kcal.'Kcal </h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            ';
        }
        ?>



    </div>
</div>

</body>

<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>

</html>