<h2>Rechercher une réservation</h2>
<form method="post" action="/Projet-Dojo/reservation/search">
    Nom responsable :
    <input type="text" name="nom_responsable" value="<?= $old['nom_responsable'] ?? '' ?>"><br>

    Date réservée :
    <input type="date" name="date" value="<?= $old['date'] ?? '' ?>"><br>

    Heure recherchée :
    <input type="time" name="heure" value="<?= $old['heure'] ?? '' ?>"><br>

    <button type="submit">Rechercher</button>
</form>

<?php if (isset($reservations)) : ?>
    <h3>Résultats :</h3>
    <?php if (!empty($reservations)) : ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Responsable</th>
                <th>Date</th>
                <th>Heure début</th>
                <th>Heure fin</th>
                <th>Contact</th>
                <th>Paiement</th>
            </tr>
            <?php foreach ($reservations as $r) : ?>
                <tr>
                    <td><?= htmlspecialchars($r['nom_responsable']) ?></td>
                    <td><?= date('Y-m-d', strtotime($r['date_reserve'])) ?></td>
                    <td><?= $r['heure_debut'] ?></td>
                    <td><?= $r['heure_fin'] ?></td>
                    <td><?= htmlspecialchars($r['contact']) ?></td>
                    <td>
                        <?php if (($r['statut_reservation'] ?? '') === 'payee') : ?>
                             Payé
                        <?php else : ?>
                            <form method="post" action="/Projet-Dojo/paiement/form">
                                <input type="hidden" name="id_reservation" value="<?= $r['id_reservation'] ?>">
                                <button type="submit">Payer</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>Aucune réservation trouvée.</p>
    <?php endif; ?>
<?php endif; ?>
