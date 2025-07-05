<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement écolage</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Paiement écolage pour <?= htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']) ?></h1>
        
        <form  method="post" action="/payer" class="max-w-md">
        <!-- <form action="payer" method="post" class="max-w-md"> -->
            <input type="hidden" name="id_eleve" value="<?= $eleve['id_eleve'] ?>">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Montant</label>
                <input type="number" name="montant" required 
                       class="w-full px-3 py-2 border rounded" value="<?=$montant ?>">
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Mois</label>
                    <select name="mois" required class="w-full px-3 py-2 border rounded">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= isset($mois) && $i == $mois ? 'selected' : '' ?>>
                                <?= DateTime::createFromFormat('!m', $i)->format('F') ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2">Année</label>
                    <select name="annee" required class="w-full px-3 py-2 border rounded">
                        <?php for ($i = date('Y') - 1; $i <= date('Y') + 1; $i++): ?>
                            <option value="<?= $i ?>" <?= isset($annee) && $i == $annee ? 'selected' : '' ?>>
                                <?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Enregistrer le paiement
            </button>
        </form>
    </div>

    <!-- <script>
        document.getElementById('paiementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch('/ecolage/paiement', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(new FormData(this)))
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    window.location.href = '/eleves/recherche';
                }
            });
        });
    </script> -->
</body>
</html>