<h2>Liste des écolages</h2>
<a href="/ecolage/create">Ajouter un paiement</a>
<table border="1">
<tr><th>ID</th><th>Élève</th><th>Montant</th><th>Mois/Année</th><th>Statut</th><th>Action</th></tr>
<?php foreach ($ecolages as $e): ?>
<tr>
    <td><?= $e['id_ecolage'] ?></td>
    <td><?= $e['id_eleve'] ?></td>
    <td><?= $e['montant'] ?> Ar</td>
    <td><?= $e['mois'] ?>/<?= $e['annee'] ?></td>
    <td><?= $e['statut'] ?></td>
    <td>
        <a href="/ecolage/<?= $e['id_ecolage'] ?>">Voir</a> |
        <a href="/ecolage/edit/<?= $e['id_ecolage'] ?>">Modifier</a> |
        <a href="/ecolage/delete/<?= $e['id_ecolage'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
