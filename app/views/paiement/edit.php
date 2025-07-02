<h2>Modifier paiement #<?= $paiement['id_payement'] ?></h2>

<form method="post" action="/Projet-Dojo/paiement/edit/<?= $paiement['id_payement'] ?>">
    <label>ID Groupe :</label><br>
    <input type="number" name="id_groupe" value="<?= $paiement['id_groupe'] ?>" required><br><br>

    <label>Montant :</label><br>
    <input type="number" step="0.01" name="montant" value="<?= $paiement['montant'] ?>" required><br><br>

    <label>Date paiement :</label><br>
    <input type="datetime-local" name="date_paiement" value="<?= date('Y-m-d\TH:i', strtotime($paiement['date_paiement'])) ?>" required><br><br>

    <button type="submit">Enregistrer</button>
</form>

