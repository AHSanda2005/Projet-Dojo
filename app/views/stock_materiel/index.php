<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<div class="container mt-4">
    <h2>Gestion du stock matériel</h2>

    <form method="POST" action="/stock/add" class="row g-3 mt-4">
        <div class="col-md-4">
            <label for="id_type" class="form-label">Type de matériel</label>
            <select class="form-select" name="id_type" required>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['id_type'] ?>"><?= htmlspecialchars($type['label']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Mouvement</label>
            <select class="form-select" name="type_mouvement" required>
                <option value="I">Entrée</option>
                <option value="O">Sortie</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Quantité</label>
            <input type="number" class="form-control" name="quantite" required min="1">
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>

    <table class="table table-bordered mt-4">
        <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Mouvement</th>
            <th>Quantité</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($stock as $entry): ?>
            <tr>
                <td><?=  (new DateTime($entry['date']))->format('Y-m-d H:i:s') ?></td>
                <td><?= $entry['id_type'] ?></td>
                <td><?= $entry['type_mouvement'] == 'I' ? 'Entrée' : 'Sortie' ?></td>
                <td><?= $entry['quantite'] ?></td>
                <td>
                    <a href="/stock/delete/<?= $entry['id_suivi'] ?>" class="btn btn-sm btn-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h4 class="mt-5">Stock actuel disponible par type</h4>
    <table class="table table-striped mt-2">
        <thead>
        <tr>
            <th>Type de matériel</th>
            <th>Stock disponible</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($stock_disponible as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['label']) ?></td>
                <td><?= $item['stock_disponible'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
