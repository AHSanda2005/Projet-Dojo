<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolution des &eacute;l&egrave;ves</title>
</head>

<body>
<div id="app">
    <div id="main">
        <h2>Evaluer la progression de <?= $eleve['nom'] ?> <?= $eleve['prenom'] ?></h2>
        <form action="/save" method="post">
            <div>
                <input type="hidden" name="eleve" value="<?= $id_eleve ?>"> <!-- id_eleve -->
                <input type="hidden" name="prof" value="<?= $id_prof ?>"> <!-- id_prof -->
            </div>
            <div>
                <label for="note">Note:</label>
                <input type="number" name="note" id="note" placeholder="Notez la progression de l'&eacute;l&egrave;ve sur 20">
            </div>
            <div>
                <label for="avis">Avis:</label>
                <textarea name="avis" id="avis" cols="30" rows="10"></textarea>
            </div>
            <input type="submit" value="Enregistrer">
        </form>
        <a href="/retour">Retour</a>
    </div>
</div>    
</body>

</html>