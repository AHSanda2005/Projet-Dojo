<h2>Liste des paiements</h2>

<a href="paiement/create">Nouveau paiement</a>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Groupe</th>
            <th>Montant</th>
            <th>Date paiement</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paiements as $p): ?>
            <tr>
                <td><?= $p['id_payement'] ?></td>
                <td><?= $p['id_groupe'] ?></td>
                <td><?= $p['montant'] ?> Ar</td>
                <td><?= $p['date_paiement'] ?></td>
                <td>
                    <a href="paiement/<?= $p['id_payement'] ?>">Voir</a> |
                    <a href="paiement/edit/<?= $p['id_payement'] ?>">Modifier</a> |
                    <a href="paiement/delete/<?= $p['id_payement'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
