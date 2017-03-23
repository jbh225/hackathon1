<?php

include 'connect.php';
$bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
mysqli_set_charset($bdd,"utf8");

// --- effacement des tables
$sql = "TRUNCATE TABLE sports";
$req = mysqli_query($bdd,$sql);
$sql = "TRUNCATE TABLE intensite";
$req = mysqli_query($bdd,$sql);





$fichier = 'sports.csv';
$fexp = fopen($fichier, 'r');
if (($ligne = fgetcsv($fexp, 2500, ';')) !== false) { // lecture ligne de titres de colonnes

    while ( $ligne = fgetcsv($fexp, 2500, ';')) {
        $infos = explode(',', $ligne[0]);

        $nbinfos = count($infos);
        $sport = $infos[0];
        $calories = $infos[$nbinfos-1];
        $intensite = '';
        for ($i=1; $i<($nbinfos-1); $i++) {
            if ( $i > 1 ) $intensite .= ', ';
            $intensite .= $infos[$i];
        }
        // --- on a 2 ou 3 elements : sport, (intensite) et calories
        $sql = "SELECT * FROM sports WHERE sport='".addslashes($sport)."'";
        $req = mysqli_query($bdd,$sql);
        if ( mysqli_num_rows($req) == 0 ) {
            // --- la ligne n'existe pas encore
            $sql = "INSERT INTO sports (sport, calories) VALUES ('".addslashes($sport)."', ";
            if ( $nbinfos > 2 ) $sql .= "0)";
            else $sql .= "$calories)";
            $req = mysqli_query($bdd,$sql);
            if ( $nbinfos > 2 ) {
                // --- il faut aussi enregistrer l'intensite
                // --- on relit pour recuperer l'id du sport que l'on vient de creer
                $sql="SELECT * FROM sports WHERE sport='".addslashes($sport)."'";
                $req = mysqli_query($bdd,$sql);
                $res = mysqli_fetch_assoc($req);
                $idsport = $res['idsport'];
                // --- on cree l'intensite
                $sql = "INSERT INTO intensite (libelle, idsport, calories) VALUES ('".addslashes($intensite)."', $idsport, $calories)";
                $req = mysqli_query($bdd,$sql);
            }
        }
        else {
            // --- le sport existe deja
            // --- on recupere idsport
            $res = mysqli_fetch_assoc($req);
            $idsport = $res['idsport'];
            // --- on cree l'intensite
            $sql = "INSERT INTO intensite (libelle, idsport, calories) VALUES ('".addslashes($intensite)."', $idsport, $calories)";
            $req = mysqli_query($bdd,$sql);
        }
        echo $sport.' '.$intensite.' '.$calories.'<br />';
    }
}
fclose($fexp);

?>