<?php

session_start();

// error_reporting(0);
ini_set('display_errors', 1);

require "../connect.php";

$accountID = $_SESSION['account_id'];
$id = $_GET["id"];


$secondDelete = $bdd->prepare("DELETE FROM invite_by_event WHERE event=".$id)->execute();

$query = $bdd->prepare("DELETE FROM event WHERE id_event=".$id)->execute();

header('Location: admin_addEvent.php');


?>
