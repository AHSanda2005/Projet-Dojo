<h2>Enregistrer un nouveau paiement</h2>

<form method="post" action="/Projet-Dojo/paiement/create">
    <label>ID Groupe :</label><br>
    <input type="number" name="id_groupe" required><br><br>

    <label>Montant :</label><br>
    <input type="number" step="0.01" name="montant" required><br><br>

    <button type="submit">Valider</button>
</form>

