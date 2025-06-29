<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<div class="container mt-4">
    <h2>Confirmation du mouvement : <?= $mouvement == 'I' ? 'Entrée' : 'Sortie' ?></h2>

    <?php if ($mouvement == 'I'): ?>
        <form method="POST" action="/stock/insert-series" class="mt-3">
            <input type="hidden" name="id_type" value="<?= $id_type ?>">
            <input type="hidden" name="quantite" value="<?= $quantite ?>">
            <?php for ($i = 1; $i <= $quantite; $i++): ?>
                <div class="mb-2">
                    <label>Numéro de série #<?= $i ?></label>
                    <input
                            type="text"
                            name="series[]"
                            class="form-control"
                            required
                            value="<?= htmlspecialchars($label_type) . str_pad($i, 3, '0', STR_PAD_LEFT) ?>"
                    >
                </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>

    <?php else: ?>
    <input type="text" id="search" placeholder="Rechercher..." class="form-control mt-2 mb-3">

        <form method="POST" action="/stock/remove-items">
            <input type="hidden" name="id_type" value="<?= $id_type ?>">
            <div id="materiel-list">
                <?php foreach ($materiels as $item): ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="selected[]" value="<?= $item['id_item'] ?>" id="item<?= $item['id_item'] ?>">
                        <label class="form-check-label" for="item<?= $item['id_item'] ?>">
                            <?= htmlspecialchars($item['num_serie']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Retirer sélection</button>
        </form>

        <script>
            const searchInput = document.getElementById('search');
            const items = document.querySelectorAll('#materiel-list .form-check');
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();
                items.forEach(item => {
                    item.style.display = item.textContent.toLowerCase().includes(query) ? 'block' : 'none';
                });
            });
        </script>
    <?php endif; ?>
</div>
