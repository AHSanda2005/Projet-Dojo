<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<div class="container mt-4">
    <h2>Suivi du Matériel en Salle</h2>

    <form method="POST" action="/suivi-salle/add" class="row g-3 mt-4">
        <div class="col-md-3">
            <label>Superviseur</label>
            <select name="id_superviseur" class="form-select" required>
                <?php foreach ($superviseurs as $s): ?>
                    <option value="<?= $s['id_superviseur'] ?>"><?= htmlspecialchars($s['nom'] . ' ' . $s['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Associer à un club ?</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="has_club" id="club_yes" value="yes" onclick="toggleClub(true)">
                <label class="form-check-label" for="club_yes">Oui</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="has_club" id="club_no" value="no" checked onclick="toggleClub(false)">
                <label class="form-check-label" for="club_no">Non</label>
            </div>

            <div id="club_select" class="mt-2" style="display: none;">
                <select name="id_club" class="form-select">
                    <option value="">-- Sélectionner un club --</option>
                    <?php foreach ($clubs as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nom_responsable']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>


        <div class="col-md-3">
            <label>Matériel</label>
            <div class="input-group">
                <input type="hidden" name="id_item" id="id_item" required>
                <input type="text" id="materiel_display" class="form-control" placeholder="Sélectionner un matériel" readonly>
                <button type="button" class="btn btn-outline-secondary" onclick="openPopup()">...</button>
            </div>
        </div>

        <div id="materielPopup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%);
     background:#fff; padding:20px; border:1px solid #ccc; z-index:9999; width:400px; max-height:400px; overflow:auto; box-shadow:0 4px 10px rgba(0,0,0,0.3);">

            <div class="mb-2 d-flex justify-content-between align-items-center">
                <label>Type</label>
                <select id="filter_type" class="form-select" style="width:200px">
                    <option value="">Tous</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['id_type'] ?>"><?= htmlspecialchars($t['label']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="text" id="popup_search" class="form-control mb-3" placeholder="Rechercher...">

            <ul id="popup_list" class="list-group">
                <?php foreach ($materiels as $m): ?>
                    <li class="list-group-item popup-item"
                        data-id="<?= $m['id_item'] ?>"
                        data-type="<?= $m['id_type'] ?>"
                        data-num="<?= htmlspecialchars($m['num_serie']) ?>"
                        onclick="selectMateriel(this)">
                        <?= htmlspecialchars($m['num_serie']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <button class="btn btn-sm btn-secondary mt-3" onclick="closePopup()">Fermer</button>
        </div>


        <div class="col-md-3">
            <label>État</label>
            <select name="etat" class="form-select">
                <option value="disponible">Disponible</option>
                <option value="endommage">Endommagé</option>
            </select>
        </div>

        <div class="col-md-6">
            <label>Description</label>
            <input type="text" name="description" class="form-control">
        </div>

        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary" type="submit">Ajouter</button>
        </div>
    </form>


    <table class="table table-bordered mt-4">
        <thead>
        <tr>
            <th>Date</th>
            <th>Superviseur</th>
            <th>Club</th>
            <th>Matériel</th>
            <th>État</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        </thead>
        <tbody>
        <?php foreach ($suivis as $s): ?>
            <tr>
                <td><?=  (new DateTime($s['date']))->format('Y-m-d H:i:s') ?></td>
                <td><?= $s['superviseur_nom'] ?> <?= $s['superviseur_prenom'] ?></td>
                <td><?= $s['nom_club'] ?? 'N/A' ?></td>
                <td><?= $s['num_serie'] ?></td>
                <td><?= $s['etat'] ?></td>
                <td><?= $s['description'] ?></td>
                <td>
<!--                    <a href="/suivi-salle/delete/--><?php //= $s['id_suivi_salle'] ?><!--" class="btn btn-sm btn-danger">Supprimer</a>-->
                    <?php if ($s['etat'] === 'endommage'): ?>
                        <?php if (empty($s['facture'])): ?>
                            <a href="/facturation/creer/<?= $s['id_suivi_salle'] ?>" class="btn btn-sm btn-warning">Faire une facturation</a>
                        <?php else: ?>
                            <span class="badge bg-success">Facture envoyée</span>
                            <a href="/facturation/pdf/<?= $s['id_suivi_salle'] ?>" class="btn btn-sm btn-info">Voir PDF</a>
                        <?php endif; ?>
                    <?php endif; ?>


                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/facturation/liste" class="btn btn-outline-dark float-end mb-3">📄 Suivi des factures</a>

</div>
<script>
    function openPopup() {
        document.getElementById('materielPopup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('materielPopup').style.display = 'none';
    }

    function selectMateriel(el) {
        const id = el.dataset.id;
        const num = el.dataset.num;
        document.getElementById('id_item').value = id;
        document.getElementById('materiel_display').value = num;
        closePopup();
    }

    document.getElementById('popup_search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('#popup_list .popup-item').forEach(item => {
            const match = item.textContent.toLowerCase().includes(query);
            item.style.display = match ? 'block' : 'none';
        });
    });

    document.getElementById('filter_type').addEventListener('change', function () {
        const typeId = this.value;
        document.querySelectorAll('#popup_list .popup-item').forEach(item => {
            const show = typeId === '' || item.dataset.type === typeId;
            item.style.display = show ? 'block' : 'none';
        });
    });
    function toggleClub(show) {
        const select = document.getElementById('club_select');
        const selectInput = select.querySelector('select');
        if (show) {
            select.style.display = 'block';
            selectInput.required = true;
        } else {
            select.style.display = 'none';
            selectInput.required = false;
            selectInput.value = ''; // vide pour forcer NULL côté serveur
        }
    }
</script>


