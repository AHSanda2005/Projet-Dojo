<h2>Nouvel écolage</h2>
<form method="post" action="/ecolage/create">
    ID élève : <input type="number" name="id_eleve" required><br>
    Montant : <input type="number" name="montant" step="0.01" required><br>
    Mois : <input type="number" name="mois" required><br>
    Année : <input type="number" name="annee" required><br>
    Statut :
    <select name="statut">
        <option>non paye</option>
        <option>paye</option>
        <option>en retard</option>
        <option>annule</option>
        <option>en attente</option>
    </select><br>
    <button type="submit">Valider</button>
</form>
