<?php
// $presences = tableau des présences pour une séance
?>
<!-- Formulaire d'insertion d'une présence -->
<form method="post" action="/presence">
    <input type="hidden" name="id_seances" value="<?= isset($_GET['id_seances']) ? htmlspecialchars($_GET['id_seances']) : '' ?>">
    <label for="id_eleve">ID Élève :</label>
    <input type="number" name="id_eleve" id="id_eleve" required>
    <label for="present">Présent :</label>
    <select name="present" id="present">
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>
    <label for="remarque">Remarque :</label>
    <input type="text" name="remarque" id="remarque">
    <button type="submit">Ajouter présence</button>
</form>

<table border="1">
    <tr>
        <th>ID Élève</th>
        <th>Présent</th>
        <th>Remarque</th>
    </tr>
    <?php foreach ($presences as $presence): ?>
    <tr>
        <td><?= htmlspecialchars($presence['id_eleve']) ?></td>
        <td><?= $presence['present'] ? 'Oui' : 'Non' ?></td>
        <td><?= htmlspecialchars($presence['remarque']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
