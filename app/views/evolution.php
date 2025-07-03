<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolution des &eacute;l&egrave;ves</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .star-rating {
            color: #ddd;
            font-size: 20px;
        }
        .star-rating .filled {
            color: gold; 
        }
    </style>
</head>

<body>
<div id="app">
    <div id="main">
        <table border="1">
            <tr>
                <th>El&egrave;ves</th>
                <th>Evolution</th>
                <th>Action</th>
            </tr>
            <?php foreach($eleve as $eleves) { ?>
                <tr>
                    <td><?= $eleves['nom'] ?> <?= $eleves['prenom'] ?></td>
                    <td>
                        <div class="star-rating">
                            <?php 
                                $starsCount = min(5, max(0, round($eleves['note'] / 4)));
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
                    <td>
                        <a href="/evolutionForm?idEleve=<?= $eleves['id_eleve'] ?>">Evaluer</a>
                        <a href="/details?idEleve=<?= $eleves['id_eleve'] ?>">D&eacute;tails</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="/statEvolution">Statistiques</a>
    </div>
</div>    
</body>

</html>