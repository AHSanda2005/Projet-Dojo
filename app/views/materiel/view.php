<html>
<head>
    <title>Détails Matériel</title>
</head>
<body>
<h2>Détails du matériel</h2>

<p><strong>Référence :</strong> <?= htmlspecialchars($type['reference']) ?></p>
<p><strong>Label :</strong> <?= htmlspecialchars($type['label']) ?></p>
<p><strong>Description :</strong> <?= nl2br(htmlspecialchars($type['description'])) ?></p>
<p><strong>Prix :</strong> <?= number_format($type['prix'], 2, ',', ' ') ?> Ar</p>

<a href="/materiel">← Retour à la liste</a>
</body>
</html>
