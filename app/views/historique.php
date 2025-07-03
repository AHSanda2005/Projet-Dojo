<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de performances</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .star-rating {
            color: #ddd;
            font-size: 20px;
        }
        .star-rating .filled {
            color: gold; 
        }
        .actions a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
<div id="app">
    <div id="main">
        <h2>Historique de performances de <?= htmlspecialchars($eleve['nom']) ?> <?= htmlspecialchars($eleve['prenom']) ?> </h2>
        <table border="1">
            <tr>
                <th>Date</th>
                <th>Professeur</th>
                <th>Avis du professeur</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
            <?php foreach($history as $historique) { ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($historique['date_evolution'])) ?></td>
                    <td><?= htmlspecialchars($historique['pnom']) ?> <?= htmlspecialchars($historique['ppnom']) ?></td>
                    <td><?= htmlspecialchars($historique['avis']) ?></td>
                    <td>
                        <div class="star-rating">
                            <?php 
                                $starsCount = min(5, max(0, round($historique['note'] / 4)));
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $starsCount) {
                                        echo '<i class="fas fa-star filled"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                            ?>
                        </div>
                    </td>
                    <td class="actions">
                        <a href="/modif?id=<?= $historique['id_evolution'] ?>&idEleve=<?= $eleve['id_eleve'] ?>">Modifier</a>
                        <a href="/supp?id=<?= $historique['id_evolution'] ?>&idEleve=<?= $eleve['id_eleve'] ?>" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">
                           Supprimer
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="/retour">Retour</a>
    </div>
</div>    
</body>

</html>