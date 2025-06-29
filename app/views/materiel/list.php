<!DOCTYPE html>
<html><head><title>Liste Matériel</title></head><body>
<h2>Liste du matériel</h2>
<a href="/materiel/create">Ajouter un matériel</a>
<table>
    <tr>
        <th>Référence</th>
        <th>Label</th>
        <th>Description</th>
        <th>Prix (Ar)</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($types as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['reference']) ?></td>
            <td><?= htmlspecialchars($m['label']) ?></td>
            <td><?= htmlspecialchars($m['description']) ?></td>
            <td><?= number_format($m['prix'], 2, ',', ' ') ?></td>
            <td>
                <a href="/materiel/<?= $m['id_type'] ?>">Voir</a>
                <a href="/materiel/<?= $m['id_type'] ?>/edit">Éditer</a>
                <a href="/materiel/<?= $m['id_type'] ?>/delete" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
