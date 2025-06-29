<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dojo - <?= $title ?? 'Application' ?></title>
    <!-- Vous pouvez ajouter ici vos CSS communs -->
</head>
<body>
    <?php 
    // Inclure la vue spécifique basée sur le paramètre 'page'
    if (isset($page) && file_exists(__DIR__ . '/' . $page . '.php')) {
        include __DIR__ . '/' . $page . '.php';
    } else {
        echo "Vue introuvable";
    }
    ?>
</body>
</html>