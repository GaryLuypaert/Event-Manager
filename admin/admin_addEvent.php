<?php

session_start();

ini_set('display_errors', 1);

require "../connect.php";

$accountID = $_SESSION['account_id'];

if(isset($_POST["name-event"]) && !empty($_POST["name-event"])) {

$event = $_POST["name-event"];
// $id = $_GET["id"];

$sql = $bdd->prepare('INSERT INTO event(nom_event) VALUES (?)');
$sql->execute(array($event));

}

$query = "SELECT * FROM event ORDER BY nom_event ASC";
$req = $bdd->query($query);
$result = $req->fetchAll(PDO::FETCH_ASSOC);


$query = "SELECT * FROM invite_by_event";
$req = $bdd->query($query);
$resInviteByEvent = $req->fetchAll(PDO::FETCH_ASSOC);



$query = "SELECT COUNT(*)as AliasCountEvent FROM event";
$req = $bdd->query($query);
$resCount = $req->fetchAll(PDO::FETCH_ASSOC);


$arrayNbrInviteByEvent = array();

foreach ($result as $event) {


    $countByEvent = 0;

    $query = "SELECT invite FROM invite_by_event WHERE event=".$event['id_event'];
    $res = $bdd->query($query);
    $stmt = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stmt as $valueIdInEvent) {

            $query = "SELECT place FROM invite WHERE id=".$valueIdInEvent['invite'];
            $res = $bdd->query($query);
            $stmt = $res->fetchAll(PDO::FETCH_ASSOC);

            $countByEvent = $countByEvent + $stmt[0]['place'];

        }

        $arrayNbrInviteByEvent[$event['id_event']]=$countByEvent;
        
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
                <div id="main-admin" class="col-md-12 shadow">
                    <h1>Administration</h1>
                    <!-- Ici viendra le code PHP pour récupérer le nom de l'event -->

                    <div class="event-table table-responsive">
                
                <table class="table table-striped table-hover table-admin">
                    <thead>
                        <tr>
                            <th>Evénements</th>
                            <th>Invités</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                    foreach ($result as $event) {
                ?>
                    <tr>
                        <td class="align-middle">
                            <a href="admin_addInvites.php?name-event=<?= $event["nom_event"]; ?>"><?= $event["nom_event"]; ?></a>
                            <?php $_SESSION["name-event"] = $event["nom_event"]; ?>
                        </td>
                        <td class="align-middle">
                            <?= $arrayNbrInviteByEvent[$event['id_event']]; ?>
                        </td>
                        <td class="align-middle">
                        <a class="btn btn-danger" href="admin_deleteEvent.php?id=<?= $event['id_event']; ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                          <!--   <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteEvent">
                                <i class="fas fa-trash-alt"></i>
                            </button> -->
                        </td>

                    </tr>
                    
                <?php
                    }
                ?>
                </tbody>

                </table>

                <a href="admin_gestion.php" class="btn btn-lg btn-info" id="btn-backEvent">
                    <i class="fas fa-plus"></i> Créer un nouvel évènement</a>
                <a href="admin_disconnect.php" class="btn btn-lg btn-danger" id="btn-disconnectEvent">
                    <i class="fas fa-power-off"></i> Déconnecter la session</a>


                <!-- Modal Confirmation Delete -->


                <?php 
                    foreach ($result as $valInviteByEvent) {

                        // print_r($valInviteByEvent['id_event']);

                ?>

                    <div class="modal fade modal-confirmDelete" id="modalDeleteEvent" tabindex="-1" role="dialog" aria-hidden="true">
<!--                         <form action="admin_deleteEvent.php" method="POST">
 -->                            <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Confirmation suppression d'évènement</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Etes-vous sûr de vouloir supprimer cet évènement <?= $valInviteByEvent['nom_event']; ?> ?</p>
                                            <button type="button" name="btnCancel" class="btn btn-primary" data-dismiss="modal">
                                            Annuler
                                            </button>
                                            <a href="admin_deleteEvent.php?id_event=<?= $valInviteByEvent['id_event']; ?>">
                                                <button type="submit" name="btnSend" id="btn-send" class="btn btn-danger">
                                                Supprimer
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
<!--                         </form>
 -->                    </div>

                    <?php
                        }
                    ?>


                </div>
                <!-- Fermeture col-md-12 -->
                </div>
                <!-- Fermeture row -->
            </div>
            <!-- Fermeture container -->
        </div>

        <footer class="container-fluid">
            © Copyright 2017 - Gary Luypaert
        </footer>
            
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <!-- <script src="../js/jQuery.js"></script> -->
        <script src="../js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>

    </body>
</html>