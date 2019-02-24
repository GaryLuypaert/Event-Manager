<?php

require "connect.php";

error_reporting(0);

$id = $_GET["id"];
// Déclarations des variables
$newNom = $_POST["new-nom"];
$newPrenom = $_POST["new-prenom"];
$newRemarque = $_POST["new-remarque"];
$newPlace = $_POST["new-place"];

// SELECT de toutes les données de la bdd
$query = "SELECT * FROM invite ORDER BY nom ASC";
$queryStmt = $bdd->query($query);
$items = $queryStmt->fetchAll(PDO::FETCH_ASSOC);

$queryEvent = "SELECT * FROM event ORDER BY nom_event ASC";
$req = $bdd->query($queryEvent);
$resultEvent = $req->fetchAll(PDO::FETCH_ASSOC);


$arrayNbrInviteByEvent = array();

foreach ($resultEvent as $event) {


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
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-switch.css" rel="stylesheet">
        <link href="style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div id="main-center" class="col-md-12">

                    <h1>Listes d'invités</h1>

                    <a href="./admin/">
                        <button class="btn btn-info btn-admin">Administration</button>
                    </a>
                    <div class="event-table">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Evénements</th>
                                    <th class="cell-compteur">Nombre d'invités</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nbr = 0;
                                foreach ($resultEvent as $event) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="event.php?id_event=<?= $event["id_event"]; ?>"><?= $event["nom_event"]; ?></a>
                                    </td>
                                    <td class="cell-compteur">
                                        <?= $arrayNbrInviteByEvent[$event['id_event']]; ?>
                                    </td>
                                    <input type='hidden' name='id' value='<?= $event['id_event']; ?>' id='input-id' />
                                </tr>
                                
                                <?php
                                $nbr++;
                                }
                                ?>
                            </tbody>
                        </table>
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
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-switch.js"></script>
        <!-- Fonction AJAX -->
        <script>
        function getXHR() {
        // Permet de vérifier que AJAX est supporté par le browser.
        var xhr = null;
        if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObjet) {
        try {
        xhr = new ActiveXObjet("Msxml2.XMLHTTP");
        }
        catch(e)
        {
        xhr = new ActiveXObjet("Microsoft.XMLHTTP");
        }
        }else {
        alert("Dll another browser");
        xhr = false;
        }
        return xhr;
        }
        function checkCompteur() {
        // Déclaration des variables et tableaux utiles au compteur
        var arrayPlaces = document.getElementsByClassName("value-place");
        var arrayTotal = new Array();
        var arrayIN = document.getElementsByClassName("etatINOUT");
        var arrayTotalIN = new Array();
        var totalPlaces = 0;
        var NbrTotalIn = 0;
        var NbrTotalOut = 0;
        // Parcours du tableau du nombre de place
        for (var i=0;i<arrayPlaces.length;i++) {
            arrayTotal.push(parseInt(arrayPlaces[i].getAttribute("value")));
            }
            // On parcours le tableau pour en additionnant toutes les valeurs du tableau
            for (var j=0;j<arrayTotal.length;j++) {
                totalPlaces += arrayTotal[j];
                }
                // Parcours du tableau de l'état de la checkbox ( IN ou OUT )
                for (var i=0;i<arrayIN.length;i++) {
                    arrayTotalIN.push(parseInt(arrayIN[i].getAttribute("value")));
                    }
                    // On défini la valeur du compteur IN
                    for (var i=0; i < arrayTotal.length;i++) {
                    var nbr = arrayTotal[i] * arrayTotalIN[i];
                    NbrTotalIn = NbrTotalIn + nbr;
                    }
                    // On définir la valeur du compteur OUT
                    NbrTotalOut = totalPlaces - NbrTotalIn;
                    // Affiche le nombre de participants selon le nombre de places des invités
                    document.getElementById("compteur").innerHTML = totalPlaces;
                    document.getElementById("compteurIN").innerHTML = NbrTotalIn;
                    document.getElementById("compteurOUT").innerHTML = NbrTotalOut;
                    }
                    function changeStatut(id, statut) {
                    // Permet de charger le contenu via AJAX
                    var xhr = getXHR();
                    var valueStatut = statut;
                    if (valueStatut !== "1") {
                    document.getElementById(id).value="1";
                    valueStatut = "1";
                    }
                    else {
                    document.getElementById(id).value="0";
                    valueStatut = "0";
                    }
                    
                    xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                    // Si tout est ok, on continue
                    checkCompteur();
                    }
                    };
                    xhr.open("GET", "update.php?statut=" + valueStatut + "&id=" + id, true);
                    // On utilise la method GET pour charger le script de la page et le true doit toujours s'y trouver
                    xhr.send(null);
                    // On lance la requête
                    }
                    </script>
                    <script src="js/jQuery.js"></script>
                </body>
            </html>