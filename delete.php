<?php

require "connect.php";

error_reporting(0);

$id = $_GET["id"];

$idEvent = $_GET['id_event'];

$query = $bdd->prepare("DELETE FROM invite_by_event WHERE invite =".$bdd->quote($id)."AND event=".$bdd->quote($idEvent))->execute();

header('Location: event.php?id_event='.$idEvent);

?>