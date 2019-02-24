<?php

session_start();

error_reporting(0);

require "../connect.php";

if(isset($_GET['name-event'])) {
    $event = $_GET['name-event'];

    $checkboxes = (isset($_POST['statut'])) ? 1 : 0;

    $query = $bdd->prepare('INSERT INTO invite(nom, prenom, remarque, place, statut) VALUES (' .$bdd->quote($_POST['nom']). ', ' .$bdd->quote($_POST['prenom']). ', '.$bdd->quote($_POST['remarque']).', ' .$bdd->quote($_POST['places']).', ' .$bdd->quote($checkboxes).' )')->execute();


    $queryEvent = "SELECT * FROM event WHERE nom_event=".$bdd->quote($event);
    $req = $bdd->query($queryEvent);
    $result = $req->fetchAll(PDO::FETCH_ASSOC);

    $queryInvite = "SELECT id FROM invite where nom = ".$bdd->quote($_POST['nom']). " AND prenom = ".$bdd->quote($_POST['prenom']);
    $reqInvite = $bdd->query($queryInvite);
    $resultInvite = $reqInvite->fetchAll(PDO::FETCH_ASSOC);

    $insertInviteByEvent = $bdd->prepare('INSERT INTO invite_by_event(invite, event) 
        VALUES ('.$resultInvite[0]["id"].', ' .$result[0]["id_event"]. ')')->execute();

}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gestion des invités</title>
        <meta charset="utf-8">
        <meta name="description">
        <meta name="keywords">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <link rel="apple-touch-icon" sizes="57x57" href="logo/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="logo/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="logo/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="logo/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="logo/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="logo/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="logo/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="logo/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="logo/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="logo/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="logo/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="logo/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="logo/favicon-16x16.png">
        
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
    <div class="container container-main">
            <div class="row">
                <div id="main-admin" class="col-md-12">
                    <br>
                    <h1>Administration</h1>
                    <br>
                    <!-- Ici viendra le code PHP pour récupérer le nom de l'event -->

                    <div class="style-form">

                        <span class="msg-insertOK">L'invité <strong><?= $_POST['nom']; ?>&nbsp;<?= $_POST['prenom']; ?></strong>&nbsp;a bien été enregistré !</span>

                        <br>

                        <a href="admin_addInvites.php?name-event=<?= $_GET['name-event'];?>" class="btn btn-default">Retour à la liste</a>
                            
        
                    </div>

                <!-- Fermeture col-md-12 -->
                </div>
                <footer class="col-md-12">
                    © Copyright 2017 - Gary Luypaert
                </footer>
                <!-- Fermeture row -->
            </div>
            <!-- Fermeture container -->
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <!-- <script src="../js/jQuery.js"></script> -->
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>



