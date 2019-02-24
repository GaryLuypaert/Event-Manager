<?php

require "connect.php";

$id = $_GET["id"];
// Déclarations des variables
$newNom = $_POST["new-nom"];
$newPrenom = $_POST["new-prenom"];
$newRemarque = $_POST["new-remarque"];
$newPlace = $_POST["new-place"];

// SHOW table
$show = "SHOW TABLES";
$queryShow = $bdd->query($show);
$result = $queryShow->fetchAll(PDO::FETCH_ASSOC)[0];

// UPDATE des informations
$update = "UPDATE invite SET nom='$newNom', prenom='$newPrenom', remarque='$newRemarque', place='$newPlace'
           WHERE id=$id ";
$updateStmt= $bdd->prepare($update);
$updateStmt->execute();

// SELECT de toutes les données de la bdd
$query = "SELECT * FROM invite ORDER BY nom ASC";
$queryStmt = $bdd->query($query);
$items = $queryStmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gestion des invités</title>
        <meta charset="utf-8">
        <meta name="description">
        <meta name="keywords">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-switch.css" rel="stylesheet">
        <link href="style.css" type="text/css" rel="stylesheet">
    </head>
    <body onload="checkCompteur();">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-middle">
                    Nombre d'invités attendus : <span id="compteur"></span>
                </div>
                <div class="navbar-right">

                    <ul>
                        <li>Présents : <span id="compteurIN"></span></li>
                        <li>En attente : <span id="compteurOUT"></span></li>
                    </ul>

                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div id="main-center" class="col-md-12">
                    <h1>Liste d'invités de l'évènement</h1>
                    <br>

                    <div id="box-table" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style='text-align:center;'>Nom des invités</th>
                                    <th style='text-align:center'>Remarque</th>
                                    <th style='text-align:center'>Places</th>
                                    <th style='text-align:center'>In&nbsp;/&nbsp;Out&nbsp;</th>
                                    <th style='text-align:center'>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="test">
                                
                                <?php
                                foreach ($items as $value) {
                                ?>
                                <tr class='<?= ($value['statut'] == 1) ? 'success' :  'danger'; ?> invite'>
                                    <td width='225px'>
                                        <span class='edit-name'><?= $value['nom']; ?></span>&nbsp;<?= $value['prenom']; ?>
                                    </td>
                                    <td width='300px' style='text-align:center'>
                                        <?= $value['remarque']; ?>
                                    </td>
                                    <td width='80px' style='text-align:center' class='value-place' id='nbrPlaces-id' value='<?= $value['place']; ?>'>
                                        <?= $value['place']; ?>
                                    </td>
                                    <td style='text-align:center' class='checkboxValue'>
                                        <input type='checkbox' id='<?= $value['id']; ?>' class='etatINOUT' onclick='changeStatut(this.id, this.value); checkCompteur();' value='<?= $value['statut']; ?>' name="statut-checkbox"/>
                                    </td>
                                    <td class="cell-actions">

                                        <a href="inviteUpdate.php?id=<?= $value['id']; ?>" class="btn btn-info btn-cell-actions">Modifier</a>

                                        <a href="delete.php?id=<?= $value['id']; ?>" class="btn btn-danger btn-cell-actions"><span class='glyphicon glyphicon-remove'></span></a>

                                    </td>
                                    <input type='text' name='id' class='hidden' value='<?= $value['id']; ?>' id='input-id' />
                                </tr>
                                <?php
                                }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>


                    <div id="insertBox" class="col-md-offset-3 col-md-6 style-form">
                        <form action="insert.php" method="POST">
                            <h4>Ajouter un invité à la liste</h4>
                            <div class="form-group">
                                <input type="text" name="nom" placeholder="Nom" id="nom" class="form-control form-inserts">
                            </div>
                            <div class="form-group">
                                <input type="text" name="prenom" placeholder="Prénom" id="prenom" class="form-control form-inserts">
                            </div>
                            <div class="form-group">
                                <input type="text" name="remarque" placeholder="Remarque" id="remarque" class="form-control form-inserts">
                            </div>
                            <div class="form-group">
                                <input type="number" name="places" placeholder="Nombres de places" id="places" class="form-control form-inserts">
                            </div>
                            <div class="form-group">
                                <label>Présent ?</label>
                                <input type="checkbox" name="statut[]" value="1" checked="checked">
                                <br>
                                <button type="submit" name="btnSend" id="btn-send" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
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


        <div id="main">
                

                
            

            
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/jQuery.js"></script>
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
    </body>
</html>