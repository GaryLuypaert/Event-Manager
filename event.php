<?php

require "connect.php";

// error_reporting(0);

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);


// Déclarations des variables
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
if(isset($_POST["new-nom"])) {
    $newNom = $_POST["new-nom"];
}
if(isset($_POST["new-prenom"])) {
    $newPrenom = $_POST["new-prenom"];
}
if(isset($_POST["new-remarque"])) {
    $newRemarque = $_POST["new-remarque"];
}
if(isset($_POST["new-place"])) {
    $newPlace = $_POST["new-place"];
}
if(isset($_GET['id_event'])) {
    $idEvent = $_GET['id_event'];
}

// SELECT de toutes les données de la bdd
$query = "SELECT * FROM invite ORDER BY nom ASC";
$queryStmt = $bdd->query($query);
$items = $queryStmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM event WHERE id_event =". $bdd->quote($_GET['id_event']);
$id_event = $bdd->query($query);
$item = $id_event->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT id, nom, prenom, remarque, place, statut
        FROM invite_by_event, invite, event 
        WHERE invite_by_event.invite = invite.id
        AND invite_by_event.event = event.id_event
        AND event.id_event = ". $item['id_event']." ORDER BY nom ASC";
$sqlStmt = $bdd->query($sql);
$itemsEvent = $sqlStmt->fetchAll(PDO::FETCH_ASSOC);

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
        <link href="style.css" type="text/css" rel="stylesheet">
    </head>
    <body onload="checkCompteur();">
        <nav class="navbar fixed-top">
            <div class="container-fluid">
                <div class="navbar-middle navbar-center">
                    Nombre d'invités attendus : <span id="compteur"></span>
                </div>
                <div class="navbar-right navbar-center">

                    <ul>
                        <li>Présents : <span id="compteurIN"></span></li>
                        <li>En attente : <span id="compteurOUT"></span></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container container-main">
            <div class="row">
                <div id="main-center" class="col-md-12 shadow">

                    <div class="header">
                        <h2>
                            <?= $item['nom_event']; ?>
                        </h2>
                    </div>     
                    
                    <div id="box-table">
                        <div class="table-responsive">
                        <table class="table table-striped table-hover" id="<?= $idEvent; ?>">
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
                                    foreach ($itemsEvent as $value) {
                                ?>

                                <tr class='<?= ($value['statut'] == 1) ? 'success' :  'danger'; ?> invite'>
                                    <td width='225px' class="align-middle">
                                        <span class='edit-name'><?php echo strtoupper($value['nom']); ?></span>&nbsp;<?= $value['prenom']; ?>
                                    </td>
                                    <td width='300px' style='text-align:center' class="align-middle">
                                        <?= $value['remarque']; ?>
                                    </td>
                                    <td width='80px' style='text-align:center' class='align-middle value-place' id='nbrPlaces-id' value='<?= $value['place']; ?>'>
                                        <?= $value['place']; ?>
                                    </td>
                                    <td style='text-align:center' class='checkboxValue align-middle'>
                                        <input type='checkbox' id='<?= $value['id']; ?>' class='align-middle etatINOUT' onclick='changeStatut(this.id, this.value); checkCompteur();' value='<?= $value['statut']; ?>' name="statut-checkbox"/>
                                    </td>
                                    <td class="align-middle cell-actions">

                                        <a href="inviteUpdate.php?id=<?= $value['id']; ?>&id_event=<?= $idEvent; ?>" class="btn btn-info btn-cell-actions edit-btn">Modifier</a>

                                        <a href="inviteUpdate.php?id=<?= $value['id']; ?>&id_event=<?= $idEvent; ?>" class="btn btn-info btn-cell-actions edit-mobile-btn"><span class='glyphicon glyphicon-pencil'></span></a>

                                        <a href="delete.php?id=<?= $value['id']; ?>&id_event=<?= $idEvent; ?>" class="btn btn-danger btn-cell-actions">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                    </td>
                                    <input type='hidden' name='id' class='hidden' value='<?= $value['id']; ?>' id='input-id' />
                                    <input type='hidden' name='id' class='hidden' value='<?= $item['id_event']; ?>' id='input-id' />

                                </tr>
                                
                                <?php
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <!-- Button trigger modal -->
                    <div class="container-buttons-bottom">
                        <button type="button" class="btn btn-primary btn-lg btn-addInvite" data-toggle="modal" data-target="#modalNewInvite">
                            <i class="fas fa-plus"></i>
                            Ajouter un invité
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <a href="./">Retour à la liste des évènements</a>
                        </button>
                    </div>
                    

                    <!-- Modal -->
                    <div class="modal fade" id="modalNewInvite" tabindex="-1" role="dialog" aria-hidden="true">
                        <form action="insert.php?id_event=<?= $idEvent; ?>" method="POST">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Ajouter un invité à la liste</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" name="nom" placeholder="Nom" id="nom" class="form-control form-inserts" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="prenom" placeholder="Prénom" id="prenom" class="form-control form-inserts" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="remarque" placeholder="Remarque" id="remarque" class="form-control form-inserts">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="places" placeholder="Nombres de places" id="places" class="form-control form-inserts" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Présent ?</label>
                                            <input type="checkbox" name="statut[]" value="1">
                                            <br>
                                        </div>
                                        <button type="submit" name="btnSend" id="btn-send" class="btn btn-success">Enregistrer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>


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
        console.log("yo");
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
                
            }
        };
        xhr.open("GET", "update.php?statut=" + valueStatut + "&id=" + id, true);
        // On utilise la method GET pour charger le script de la page et le true doit toujours s'y trouver
        xhr.send();
        // On lance la requête
    }

    </script>
    <script src="js/jquery.js"></script>
    </body>
</html>