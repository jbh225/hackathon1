<?php
include 'connect.php';

$bdd = mysqli_connect(SERVER, USER, PASS, DB);
mysqli_set_charset($bdd,"utf8");

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
<header>
    <div class="jumbotron">

    </div>
</header>
	<div class="row">
  		<div class="col-xs-6 col-md-3 col-xs-offset-4">
  		<h2>Allez on se bouge !</h2>
    		<a href="#" class="thumbnail">
      			<img src="images/fruits.jpg" alt="photos fruits">
                <h1>Calories</h1>
    		</a>
			<br/>
            <p>Comment on élimine tout ça?</p>

			<form method="post" action="calories.php">
                <select name="sports">


                    <?php

                        $req = "SELECT idsport, sport, calories FROM sports ORDER BY sport";
                        $res = mysqli_query($bdd, $req);



                        while($data = mysqli_fetch_assoc($res))
                        {
                          echo '<option value="'.$data['idsport'].'">'. $data['sport'].'</option>';
                        }
                    ?>


                </select>
                <br/>
				<br/>

				<input class="btn btn-success" type="submit" name="btnSubmit" value="C'est parti !" />

			</form>
  		</div>

  
	</div>




</body>
</html>