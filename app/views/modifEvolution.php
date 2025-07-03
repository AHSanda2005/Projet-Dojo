<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'&eacute;volution</title>
</head>

<body>
<div id="app">
    <div id="main">
        <h2>Modifier la progression de <?= $eleve['nom'] ?> <?= $eleve['prenom'] ?></h2>
        <form action="/updateEvolution" method="post">
            <div>
                <input type="hidden" name="evolution" value="<?= $id ?>"> <!-- id_evolution -->
                <input type="hidden" name="idEleve" value="<?= $idEleve ?>"> <!-- id_eleve -->
            </div>
            <div>
                <label for="note">Note:</label>
                <input type="number" name="note" id="note" value="<?= $progression['note'] ?>">
            </div>
            <div>
                <label for="avis">Avis:</label>
                <textarea name="avis" id="avis" cols="30" rows="10"><?= $progression['avis'] ?></textarea>
            </div>
            <input type="submit" value="Modifier">
        </form>
    </div>
</div>    
</body>

</html>