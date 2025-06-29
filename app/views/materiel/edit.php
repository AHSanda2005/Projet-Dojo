<html><head><title>Éditer Matériel</title></head><body>
<h2>Éditer matériel</h2>
<?php if (!empty($error)): ?>
    <div style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="/materiel/<?= $type['id_type'] ?>/update">
    <label>Label :
        <input type="text" name="label" value="<?= htmlspecialchars($type['label']) ?>" required>
    </label><br>

    <label>Description :
        <textarea name="description"><?= htmlspecialchars($type['description']) ?></textarea>
    </label><br>

    <label>Prix (Ar) :
        <input type="number" name="prix" value="<?= htmlspecialchars($type['prix']) ?>" step="0.01" min="0" required>
    </label><br>

    <button type="submit">Mettre à jour</button>
</form>
