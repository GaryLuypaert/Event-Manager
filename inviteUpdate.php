<?php

require "connect.php";

error_reporting(0);

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

$query = "SELECT * FROM invite WHERE id=$id";
$queryStmt = $bdd->query($query);
$items = $queryStmt->fetchAll(PDO::FETCH_ASSOC)[0];

$queryEvent = "SELECT * FROM event";
$req = $bdd->query($queryEvent);
$resultEvent = $req->fetchAll(PDO::FETCH_ASSOC);

// UPDATE des informations
$update = "UPDATE invite SET nom='$newNom', prenom='$newPrenom', remarque='$newRemarque', place='$newPlace'
           WHERE id=$id ";
$updateStmt= $bdd->prepare($update);
$updateStmt->execute();

if(isset($newNom)) {
    header("Location: event.php?id_event=".$idEvent);
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
        <link href="style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div id="main-center" class="col-md-12">
                    <h1>Liste d'invités de l'évènement</h1>
                    <div class="container-update">

                            <div class="col-md-6 style-form">

                                <h4>Modification des informations de l'invité</h4>

                                <form method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?= $items['nom']; ?>" name="new-nom" placeholder="Nom"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?= $items['prenom']; ?>" name="new-prenom" placeholder="Prénom"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?= $items['remarque']; ?>" name="new-remarque" placeholder="Remarque"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control" value="<?= $items['place']; ?>" name="new-place" placeholder="Places"/>
                                    </div>
                                    <input type='hidden' name='id' value='<?= $resultEvent['id_event']; ?>' id='input-id' />
                                    <button type="submit" class="btn btn-success" name="btn-update">Mettre à jour</button>

                                </form>
                            
                            </div>
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


    function changeStatut(id, statut) {
        // Permet de charger le contenu via AJAX
        var xhr = getXHR();
        // On appelle la fonction pour vérifier le browser et on l'attribue à xhr
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
        xhr.send(null);
        // On lance la requête
    }

</script>
    </body>
</html>