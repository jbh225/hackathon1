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
        <h1>Bougez +
            <small>pour manger +</small>
        </h1>
    </div>
</header>
<div class="container">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 text-center">
                <div class="thumbnail calor">
                    <h2><?php echo $name; ?></h2>
                    <img src="<?php echo $urlimg; ?>" alt="...">
                    <h2>Calories : <?php echo $kcal; ?></h2>
                </div>
            </div>

            <div class="col-xs-6 text-center">
                <div class="thumbnail">
                    <h2>Comment éliminer tout ça?</h2>
                    Choisir une activité physique :<br/><br/>

                    <select name="sport" id="sport" onchange="majIntensite();">
                        <?php
                        foreach ($sports as $id => $sport) {
                            echo '<option value="' . $id . '">' . $sport . '</option>';
                        }
                        ?>
                    </select>
                    <br/>
                    <br/>
                    <br/>
                    <select name="intensite" id="intensite">
                        <option value="0"> - Aucun choix -</option>
                    </select>
                    <br/>
                    <br/>
                    <br/>
                    <div class="btn btn-success" onclick="calcule();">C'est parti !</div>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <span id="resultat"></span>
                    <br/>
                    <br/>
                    <br/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-center">
                    <br>
                    <div class="retour">
                        <a href="index.php" button type="button" class="btn btn-default" aria-label="Left Align">
                            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>


        </div>
        <script type="text/javascript" src="js/calories.js"></script>
        <script>majIntensite();</script>
</body>
</html>