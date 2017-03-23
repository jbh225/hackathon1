<?php
    if (isset($_GET['produit'])) $produit = $_GET['produit'];
    if (isset($_GET['nbprod'])) $nbprod = $_GET['nbprod'];
    if (isset($_GET['nbpages'])) $nbpages = $_GET['nbpages'];
    if (isset($_GET['numpage'])) $numpage = $_GET['numpages'];
    else $numpage = 1;

    $rep = file_get_contents('https://fr-en.openfoodfacts.org/category/'.$produit.'/'.$numpage.'.json');
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
    <link rel="stylesheet" type="text/css" href="cam.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<header>
        <h1>Bougez +
            <small>pour manger +</small>
        </h1>
        <hr>
</header>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2>
                Produit : <?php echo $produit; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $nbprod; ?> produits
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                page <?php echo $numpage.'/'.$nbpages; ?>
            </h2>

        </div>
    </div>

    <div class="row">
    <?php

        foreach ($products as $product) {
            if ( property_exists($product, 'image_front_thumb_url') ) $urlimg = $product->image_front_thumb_url;
            elseif ( property_exists($product, 'image_front_small_url') ) $urlimg = $product->image_front_small_url;
            elseif ( property_exists($product, 'image_front_url') ) $urlimg = $product->image_front_url;
            echo '
            <div class="col-lg-3 text-center">
                <div class="thumbnail vignette">
                    <img class="miniature" src="'.$urlimg.'" alt="...">
                    <div class="caption">
                        <h3>'.$product->product_name_fr.'</h3>
                    </div>
                    <p><a href="calories.html" class="btn btn-default" role="button">Manger</a></p>
                </div>
            </div>
            ';
        }
    ?>
 
    </div>
</div>

<footer>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</footer>
</body>


<link href="js/bootstrap.js">


</html>