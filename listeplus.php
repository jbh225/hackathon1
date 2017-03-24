<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // --- connexion database
    include 'connect.php';
    $bdd = mysqli_connect(SERVER, USER, PASS, DB);
    mysqli_set_charset($bdd, "utf8");
    // --- lecture des infos
    $sql = "SELECT * FROM intensite WHERE idsport=$id ORDER BY libelle";
    $rep = mysqli_query($bdd, $sql);
    echo 'ToutBon#';
    while ($infos=mysqli_fetch_assoc($rep)) {
        echo $infos['idintensite'].'*'.$infos['libelle'].'*'.$infos['calories'].'#';
    }


}