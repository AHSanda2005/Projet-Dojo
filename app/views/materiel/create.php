<!DOCTYPE html>
<html><head><title>Ajouter Matériel</title></head><body>
<h2>Ajouter un matériel</h2>
<form method="post" action="/materiel/store">
    <label>Label :
        <input type="text" name="label" required>
    </label><br>

    <label>Ref :
        <input type="text" name="reference" required>
    </label><br>

    <label>Description :
        <textarea name="description"></textarea>
    </label><br>

    <label>Prix (Ar) :
        <input type="number" name="prix" step="0.01" min="0" required>
    </label><br>

    <button type="submit">Enregistrer</button>
</form>
