<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaire</title>
</head>
<body>
<div id="app">
    <div id="main">
        <h2>Liste des personnels</h2>
        <form action="" method="post">
            <div>
                <input type="text" name="nomPers" placeholder="ex. Rakoto">
                <input type="submit" value="Rechercher">
            </div>
        </form>
        <br>
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Profession</th>
                <th>Contact</th>
            </tr>
            <?php foreach($personnels as $personnel) : ?>
                <tr>
                    <td><a href="detail.php?id=<?= $personnel['id_prof'] ?? $personnel['id_superviseur'] ?>&type=<?= $personnel['profession'] ?>">
                        <?= htmlspecialchars($personnel['nom'] ?? '') ?>
                    </a></td>
                    <td><?= htmlspecialchars($personnel['prenom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($personnel['profession'] ?? '') ?></td>
                    <td><?= htmlspecialchars($personnel['contact'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div id="detail-panel">
            <div class="no-selection" id="no-selection-message">
                Sélectionnez un personnel pour afficher ses détails
            </div>
            
            <div id="personnel-details" style="display: none;">
                <h2>Détails du personnel</h2>
                <div class="personnel-info">
                    <p><span class="info-label">Nom:</span></p>
                    <p><span class="info-label">Prénom:</span></p>
                    <p><span class="info-label">Profession:</span></p>
                    <p><span class="info-label">Contact:</span></p>
                </div>
                
                <h3>Effectuer un paiement</h3>
                <form id="payment-form">
                    <input type="hidden" id="personnel-id">
                    <div class="form-group">
                        <label for="salaire">Salaire à payer (Ar):</label>
                        <input type="number" id="salaire" name="salaire" min="0" step="1000" placeholder="Entrez le montant">
                    </div>
                    <div class="form-group">
                        <label for="mois">Mois à payer:</label>
                        <input type="month" id="mois" name="mois">
                    </div>
                    <button type="button" onclick="payer()">Enregistrer le paiement</button>
                </form>
            </div>
        </div>
    </div>
</div>    
</body>
</html>