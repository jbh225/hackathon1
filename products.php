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
        <div class="col-xs-12">
            <h2>
                Produit : <?php echo $produit; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $nbprod; ?> produits
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                page <?php echo $numpage . '/' . $nbpages; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                // --- preparation des boutons page precedente/suivante
                $avant = $apres = 'products.php?produit=' . $produit . '&nbprod=' . $nbprod . '&nbpages=' . $nbpages;
                $avant .= '&numpage=' . ($numpage - 1);
                $apres .= '&numpage=' . ($numpage + 1);
                if ($numpage > 1) {
                    echo '<a class="btn btn-default avant" href="' . $avant . '">Page précédente</a>';
                    echo '&nbsp;&nbsp;';
                }
                if ($numpage < $nbpages) {
                    echo '<a class="btn btn-default apres" href="' . $apres . '">Page suivante</a>';
                }

                ?>
            </h2>

        </div>
    </div>

    <div class="row">
        <?php

        foreach ($products as $product) {
            if (property_exists($product, 'image_front_url')) $urlimg = $product->image_front_url;
            elseif (property_exists($product, 'image_front_small_url')) $urlimg = $product->image_front_small_url;
            elseif (property_exists($product, 'image_front_thumb_url')) $urlimg = $product->image_front_thumb_url;
            echo '
                <div class="col-lg-3 text-center">
                    <div class="thumbnail vignette">
                        <img class="miniature" src="' . $urlimg . '" alt="...">
                        <div class="caption">
                            <h3>' . $product->product_name_fr . '</h3>
                        </div>
                        <p>
            ';
            if (property_exists($product, 'nutrition_grades')) {
                echo '<img class="nutrigrade" src="images/nutriscore-' . $product->nutrition_grades . '.svg" />';
                echo '&nbsp;&nbsp;';
            }
            echo '
                            <a href="calories.php?id=' . $product->id . '" class="btn btn-default" role="button">Manger</a>
                        </p>
                    </div>
                </div>
            ';
        }
        ?>

    </div>
</div>
</body>

<link href="js/bootstrap.js">

</html>