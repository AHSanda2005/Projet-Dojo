<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-light">
            <div class="card-body position-relative">
                <h6>Total Matériels</h6>
                <h3><?= $stats['total_materiels'] ?></h3>
                <a href="/materiel" class="stretched-link"></a>
            </div>

        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h6>Matériels en Salle</h6>
                <h3><?= $stats['materiels_en_salle'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h6>Types de Matériels</h6>
                <h3><?= $stats['types'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h6>Stock Disponible</h6>
                <h3><?= $stats['stock_disponible'] ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-warning text-dark">
            <div class="card-body">
                <h6>Endommagés</h6>
                <h3><?= $stats['endommagés'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h6>Factures envoyées</h6>
                <h3><?= $stats['factures'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h6>Payées</h6>
                <h3><?= $stats['payees'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center bg-danger text-white">
            <div class="card-body">
                <h6>Non Payées</h6>
                <h3><?= $stats['non_payees'] ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h6>Total Facturé</h6>
                <h3><?= number_format($stats['montant_total'], 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card text-center bg-danger text-white">
            <div class="card-body">
                <h6>🔻 Pertes estimées (endommagés)</h6>
                <h3><?= number_format($stats['pertes'], 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
</div>
