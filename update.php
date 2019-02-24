<?php

require "connect.php";

error_reporting(0);

if (isset($_GET["statut"]) && isset($_GET["id"])) {
    $statut = isset($_GET["statut"]) ? $_GET["statut"] : 0;
    $id = isset($_GET["id"]) ? $_GET["id"] : 0;
    $idEvent = isset($_GET["id_event"]) ? $_GET["id_event"] : 0;

    $sql = "UPDATE invite SET statut='$statut' WHERE id=$id ";
    $items = $bdd->prepare($sql);
    $items->execute();

    header("Location: event.php?id_event=".$idEvent);

}

?>
