<h2>Paiements pour le groupe #<?= $id_groupe ?></h2>

<a href="/paiement">← Tous les paiements</a>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID Paiement</th>
            <th>Montant</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paiements as $p): ?>
            <tr>
                <td><?= $p['id_payement'] ?></td>
                <td><?= $p['montant'] ?> Ar</td>
                <td><?= $p['date_paiement'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
