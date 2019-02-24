<?php 
require 'connect.php';

$query = "SELECT * FROM invite ORDER BY nom ASC";
$queryStmt = $bdd->query($query);
$items = $queryStmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT id_event FROM event WHERE id_event =". $bdd->quote($_GET['id_event']);
$id_event = $bdd->query($query);
$item = $id_event->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT nom, prenom, remarque, place, statut
        FROM invite_by_event, invite, event 
        WHERE invite_by_event.invite = invite.id
        AND invite_by_event.event = event.id_event
        AND event.id_event = ". $item['id_event'];
$sqlStmt = $bdd->query($sql);
$itemsEvent = $sqlStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<table class="table">
                    
                <thead>
                    <tr>
                        <th style='text-align:center'>Nom des invités</th>
                        <th style='text-align:center'>Remarque</th>
                        <th style='text-align:center'>Nombre de places</th>
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