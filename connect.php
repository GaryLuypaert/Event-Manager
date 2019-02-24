<?php

$dbHost = "localhost";
$dbName = "database";
$dbUser = "root";
$dbPassword = "root";

try
{
    $bdd = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.';charset=utf8', $dbUser, $dbPassword);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

?>