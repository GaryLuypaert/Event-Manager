<?php

session_start();

error_reporting(0);

require "../connect.php";

$accountID = $_SESSION['account_id'];

$query = "SELECT * FROM event";
$req = $bdd->query($query);
$result = $req->fetchAll(PDO::FETCH_ASSOC);

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
                    <div class="container-update">
                    <!-- Ici viendra le code PHP pour récupérer le nom de l'event -->

                        <div class="col-md-6 style-form">
                            <h4>Création d'un évènement</h4>

                            <form action="admin_addEvent.php" method="POST">
                                <div class="form-group">
                                    <label for="event">Evenement</label>
                                    <input type="text" class="form-control" value="" name="name-event" placeholder="Nom de l'évènement" />
                                    
                                    
                                    
                            <?php 
                                foreach ($result as $value) {
                            ?>
                                <input type='hidden' name='id' value='<?= $value['id_event']; ?>' id='input-id' />
                                    
                            <?php
                                }
                            ?>

                                </div>
                            <button type="submit" class="btn btn-success" name="btn-add-event">Créer l'évènement</button>
                        </form>

                        <a href="admin_addEvent.php" class="btn btn-info"><i class="fas fa-list"></i> Liens vers les évènements</a>
                        <a href="admin_disconnect.php" class="btn btn-danger"><i class="fas fa-power-off"></i> Déconnecter la session</a>
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
        <!-- <script src="../js/jQuery.js"></script> -->
        <script src="../js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    </body>
</html>