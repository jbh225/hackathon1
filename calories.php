<?php

// --- connexion database
include 'connect.php';
$bdd = mysqli_connect(SERVER, USER, PASS, DB);
mysqli_set_charset($bdd, "utf8");
// --- recuperation des sports
$sports = $intensites = [];
$req = "SELECT idsport, sport, calories FROM sports ORDER BY sport";
$res = mysqli_query($bdd, $req);
while ($data = mysqli_fetch_assoc($res)) {
    $sports[$data['idsport']] = $data['sport'];
    $intensites[$data['idsport']] = $data['calories'];
}

// --- recuperation code produit
if (!isset($_GET['id'])) header('location:index.php');
else {
    $id = $_GET['id'];
    $rep = file_get_contents('http://fr.openfoodfacts.org/api/v0/produit/' . $id . '.json');
    $infos = json_decode($rep);
    $product = $infos->product;
    if (property_exists($product, 'image_front_url')) $urlimg = $product->image_front_url;
    elseif (property_exists($product, 'image_front_small_url')) $urlimg = $product->image_front_small_url;
    elseif (property_exists($product, 'image_front_thumb_url')) $urlimg = $product->image_front_thumb_url;
    $energie = $product->nutriments;
    $kj = $energie->energy;
    $kcal = round($kj * 0.239, 0);
    $name = '';
    if (property_exists($product, 'product_name_fr')) $name = $product->product_name_fr;
    elseif (property_exists($product, 'generic_name_fr')) $name = $product->generic_name_fr;


}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <title>Calories</title>
</head>


<body>
<script>
    var calories = new Array();
    <?php foreach ($intensites as $id => $calories) echo "calories[$id] = $calories;"; ?>
    var kCal = <?php echo $kcal; ?>;
    var nomProd = '<?php echo $name; ?>';
</script>
<header>
    <div class="jumbotron">

    </div>
</header>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-6 text-center">
            <h2>Allez on se bouge !</h2>
            <a href="#" class="thumbnail">
                <img src="<?php echo $urlimg; ?>" alt="...">
                <h1>Calories : <?php echo $kcal; ?></h1>
            </a>
        </div>

        <div class="col-xs-6 text-center">

            <p>Comment on élimine tout ça?</p>

            <select name="sport" id="sport" onchange="majIntensite();">
                <?php
                foreach ($sports as $id => $sport) {
                    echo '<option value="' . $id . '">' . $sport . '</option>';
                }
                ?>
            </select>
            <br/><br/>
            <select name="intensite" id="intensite">
                <option value="0"> - Aucun choix -</option>
            </select>
            <br/>
            <br/>

            <div class="btn btn-success" onclick="calcule();">C'est parti !</div>
            <br/>
            <br/>
            <span id="resultat"></span>
            <br/>
            <br/>
            <br/>

            <span class="retour">
                <a href="index.php" button type="button" class="btn btn-default" aria-label="Left Align">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                </a>
            </span>
            <!--
           <a href="index.php" class="btn btn-default">Choix d'un type de produit</a>
            -->

        </div>


    </div>

</div>
<script type="text/javascript" src="js/calories.js"></script>
<script>majIntensite();</script>
</body>
</html>