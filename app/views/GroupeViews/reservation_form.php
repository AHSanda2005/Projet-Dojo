<h2>Ajouter une Réservation</h2>

<form method="post" action="/S4(htdocs)/Projet-Dojo/reservation/insert">
    <label>ID Club:</label><br>
    <input type="number" name="id_club" required><br>

    <label>Date de réservation:</label><br>
    <input type="datetime-local" name="date_reservation" required><br>

    <label>Date réservée:</label><br>
    <input type="datetime-local" name="date_reserve" required><br>

    <label>Heure de début:</label><br>
    <input type="time" name="heure_debut" required><br>

    <label>Heure de fin:</label><br>
    <input type="time" name="heure_fin" required><br><br>

    <input type="submit" value="Ajouter">
</form>

<?php if (!empty($message)): ?>
    <p style="color:green;"><?= $message ?></p>
<?php endif; ?>

<a href="/reservations">← Retour à la liste</a>
