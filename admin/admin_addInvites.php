<?php

session_start();

error_reporting(0);

require "../connect.php";

$accountID = $_SESSION['account_id'];


if(isset($_GET["name-event"])){
    $event = $_GET["name-event"];
}else{
    $event = 'test_event';
}

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
                <div id="main-admin" class="col-md-12">
                    <br>
                    <h1>Administration</h1>
                    <br>
                    <!-- Ici viendra le code PHP pour récupérer le nom de l'event -->







<div id="box-table">
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

                                    <!-- <input type="hidden" name="event" value=""> -->


                                </tr>
                                
                                <?php
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>







                    <div id="insertBox" class="col-md-offset-3 col-md-6 style-form">
                    <form action="admin_confirmInsert.php?name-event=<?= $event; ?>" method="POST">
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

                        <input type="hidden" name="name-event" value="<?= $event; ?>">
                    </form>
                    <a href="admin_addEvent.php" class="btn btn-info"><span class='glyphicon glyphicon-list'></span> Retour aux évènements</a>
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