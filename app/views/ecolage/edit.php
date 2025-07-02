<h2>Modifier écolage #<?= $ecolage['id_ecolage'] ?></h2>
<form method="post" action="/ecolage/edit/<?= $ecolage['id_ecolage'] ?>">
    ID élève : <input type="number" name="id_eleve" value="<?= $ecolage['id_eleve'] ?>"><br>
    Montant : <input type="number" name="montant" value="<?= $ecolage['montant'] ?>"><br>
    Mois : <input type="number" name="mois" value="<?= $ecolage['mois'] ?>"><br>
    Année : <input type="number" name="annee" value="<?= $ecolage['annee'] ?>"><br>
    Statut :
    <select name="statut">
        <option <?= $ecolage['statut'] === 'non paye' ? 'selected' : '' ?>>non paye</option>
        <option <?= $ecolage['statut'] === 'paye' ? 'selected' : '' ?>>paye</option>
        <option <?= $ecolage['statut'] === 'en retard' ? 'selected' : '' ?>>en retard</option>
        <option <?= $ecolage['statut'] === 'annule' ? 'selected' : '' ?>>annule</option>
        <option <?= $ecolage['statut'] === 'en attente' ? 'selected' : '' ?>>en attente</option>
    </select><br>
    <button type="submit">Mettre à jour</button>
</form>
