<h2 class="text-xl font-bold mb-4">Liste des paiements</h2>

<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">Montant</th>
            <th class="px-4 py-2">Mois</th>
            <th class="px-4 py-2">Année</th>
            <th class="px-4 py-2">Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paiements as $p): ?>
            <tr>
                <td class="border px-4 py-2"><?= date('d/m/Y', strtotime($p['date_paiement'])) ?></td>
                <td class="border px-4 py-2"><?= $p['montant'] ?> Ar</td>
                <td class="border px-4 py-2"><?= $p['mois'] ?></td>
                <td class="border px-4 py-2"><?= $p['annee'] ?></td>
                <td class="border px-4 py-2"><?= $p['statut'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
