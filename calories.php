<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="style.css">

	<title>Calories</title>
</head>

<?php

include 'connect.php';
$bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
mysqli_set_charset($bdd,"utf8");

   ?>
<body>
	<header>
		<div class="page-header">
			<center><h1>Bouger + pour manger +</h1></center>
		</div>
	</header>
	<div class="row">
  		<div class="col-xs-6 col-md-3 col-xs-offset-4">
  		<h1>Nom du produit</h1>
    		<a href="#" class="thumbnail">
      			<img src="images/fruits.jpg" alt="photos fruits">
    		</a>
    		<h1>Calories</h1>
			<br/>
			<form method="post" action="calories.php">
				<p>Quel sport choisissez-vous?</p>
				<input type="text" class="form-control" placeholder="Sports">
				<br/>
                <p>Pour combien de calories?</p>
                <input type="text" class="form-control" placeholder="Nombre de calories">
                <br/>
				<input class="btn btn-success" type="submit" name="btnSubmit" value="Rechercher" />

			</form>
  		</div>

  
	</div>

</body>
</html>