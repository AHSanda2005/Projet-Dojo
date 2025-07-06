<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du temps - <?= "$mois/$annee" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .calendar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .day {
            background: #f8f9fa;
            padding: 10px;
            border: 1px solid #ccc;
            min-width: 250px;
            flex: 1 1 calc(50% - 10px);
        }

        .day h6 {
            margin-top: 0;
            font-weight: bold;
        }

        .seance, .reservation, .abonnement {
            font-size: 0.85rem;
            margin-bottom: 8px;
            padding: 4px;
            border-radius: 4px;
        }

        .seance {
            background-color: #e2e6ea;
        }

        .reservation {
            background-color: #fff3cd;
        }

        .abonnement {
            background-color: #d4edda;
        }

        .details-link {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Calendrier complet de <?= $mois ?>/<?= $annee ?></h2>

    <div class="mb-3">
        <a class="btn btn-secondary" href="?mois=<?= ($mois == 1 ? 12 : $mois - 1) ?>&annee=<?= ($mois == 1 ? $annee - 1 : $annee) ?>">← Mois précédent</a>
        <a class="btn btn-secondary ms-2" href="?mois=<?= ($mois == 12 ? 1 : $mois + 1) ?>&annee=<?= ($mois == 12 ? $annee + 1 : $annee) ?>">Mois suivant →</a>
    </div>

    <div class="calendar">
        <?php for ($i = 1; $i <= 31; $i++): ?>
            <?php if (!checkdate($mois, $i, $annee)) continue; ?>
            <div class="day">
                <h6><?= $i ?>/<?= $mois ?></h6>

                <?php if (isset($calendrier[$i])): ?>
                    <?php foreach ($calendrier[$i] as $item): ?>
                        <?php if (isset($item['type']) && $item['type'] === 'club'): ?>
                            <div class="club">
                                <strong><?= ucfirst($item['type']) ?></strong><br>
                                Club : <?= htmlspecialchars($item['club_nom'] ?? 'Inconnu') ?><br>
                                Discipline : <?= htmlspecialchars($item['discipline'] ?? 'Non précisée') ?><br>
                                <?php if (!empty($item['heure_debut'])): ?>
                                    Heure : <?= htmlspecialchars($item['heure_debut']) ?> - <?= htmlspecialchars($item['heure_fin']) ?>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="seance">
                                <?= htmlspecialchars($item['heure_debut']) ?> - <?= htmlspecialchars($item['heure_fin']) ?><br>
                                <?php if (isset($item['groupe'])): ?>
                                    Groupe <?= htmlspecialchars($item['groupe']) ?><br>
                                <?php endif; ?>
                                <?= htmlspecialchars($item['cours']) ?><br>
                                Prof : <?= htmlspecialchars($item['prof_nom']) ?> <?= htmlspecialchars($item['prof_prenom']) ?><br>
                                <a href="/calendrier/details?date=<?= "$annee-$mois-$i" ?>&groupe=<?= $item['groupe'] ?? 0 ?>" class="details-link">Détails</a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                <?php else: ?>
                    <small>Aucune activité</small>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
</body>
</html>