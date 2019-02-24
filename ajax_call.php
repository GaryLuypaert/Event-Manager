<?php 

require_once 'connect.php';

error_reporting(0);

$query = "SELECT * FROM invite ORDER BY nom ASC";
$queryStmt = $bdd->query($query);
$items = $queryStmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM event WHERE id_event =". $bdd->quote($_GET['id_event']);
$id_event = $bdd->query($query);
$item = $id_event->fetch(PDO::FETCH_ASSOC);

$idEvent = $_GET['id_event'];

$sql = "SELECT id, nom, prenom, remarque, place, statut
        FROM invite_by_event, invite, event 
        WHERE invite_by_event.invite = invite.id
        AND invite_by_event.event = event.id_event
        AND event.id_event = ". $item['id_event']." ORDER BY nom ASC";
$sqlStmt = $bdd->query($sql);
$itemsEvent = $sqlStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div id="box-table">
    <div class="table-responsive">
<table class="table table-striped table-hover" id="<?= $idEvent; ?>">
                    
                <thead>
                    <tr>
                        <th style='text-align:center'>Nom des invités</th>
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
                        <td width='80px' style='text-align:center' class='value-place align-middle' id='nbrPlaces-id' value='<?= $value['place']; ?>'>
                            <?= $value['place']; ?>        
                        </td>
                        <td style='text-align:center' class='checkboxValue align-middle'>
                            <input type='checkbox' id='<?= $value['id']; ?>' class='etatINOUT' onclick='changeStatut(this.id, this.value); checkCompteur();' value='<?= $value['statut']; ?>' name="statut-checkbox"/>
                        </td>
                        <td class="cell-actions align-middle">

                            <a href="inviteUpdate.php?id=<?= $value['id']; ?>&id_event=<?= $idEvent; ?>" class="btn btn-info btn-cell-actions edit-btn">Modifier</a>

                            <a href="inviteUpdate.php?id=<?= $value['id']; ?>&id_event=<?= $idEvent; ?>" class="btn btn-info btn-cell-actions edit-mobile-btn"><span class='glyphicon glyphicon-pencil'></span></a>

                            <a href="delete.php?id=<?= $value['id']; ?>&id_event=<?= $idEvent; ?>" class="btn btn-danger btn-cell-actions">
                                <i class="fas fa-trash-alt"></i>
                            </a>

                        </td>
                        <input type='hidden' name='id' value='<?= $value['id']; ?>' id='input-id' />
                        
                        </tr>

                <?php
                    }
                ?>

            
                </tbody>
                </table>
            </div>
            </div>