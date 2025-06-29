<div class="container mt-4">
    <h2>Liste des Factures</h2>
    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Matériel</th>
            <th>Description</th>
            <th>Montant</th>
            <th>Destinataire</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($factures as $f): ?>
            <tr>
                <td><?= $f['id_facture'] ?></td>
                <td><?= date('d/m/Y', strtotime($f['date'])) ?></td>
                <td><?= htmlspecialchars($f['num_serie']) ?> (<?= htmlspecialchars($f['label']) ?>)</td>
                <td><?= htmlspecialchars($f['description']) ?></td>
                <td><?= number_format($f['montant'], 2, ',', ' ') ?> Ar</td>
                <td><?= htmlspecialchars($f['destinataire']) ?></td>
                <td>
                    <?php if ($f['est_paye']): ?>
                        <span class="badge bg-success">Payée</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">En attente</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!$f['est_paye']): ?>
                        <a href="/facturation/valider/<?= $f['id_facture'] ?>" class="btn btn-sm btn-success">Valider paiement</a>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
