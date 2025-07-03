<?php
<h2>Enregistrer un nouveau paiement</h2>

<form method="post" action="/Projet-Dojo/paiement/create">
    <label>ID Réservation :</label><br>
    <input type="number" name="id_reservation" required><br><br>

    <label>Montant :</label><br>
    <input type="number" step="0.01" name="montant" required><br><br>

    <button type="submit">Valider</button>
</form>