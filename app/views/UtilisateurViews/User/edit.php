<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Utilisateur</title>
</head>
<body>
    <div>
        <h1>Modifier un Utilisateur</h1>
        
        <a href="/users">← Retour à la liste</a>

        <!-- Message d'erreur -->
        <?php if (isset($error) && $error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de modification -->
        <form method="POST" action="/users/update/<?php echo htmlspecialchars($type); ?>/<?php echo $user->{'getId' . ucfirst($type)}(); ?>">
            
            <!-- Informations sur le type d'utilisateur -->
            <div>
                <p><strong>Type d'utilisateur :</strong> 
                    <?php 
                    $typeLabels = [
                        'eleve' => 'Élève',
                        'prof' => 'Professeur', 
                        'superviseur' => 'Superviseur',
                        'parent' => 'Parent'
                    ];
                    ?>
                </p>
            </div>

            <!-- Nom -->
            <div>
                <label for="nom">Nom <span>*</span></label>
                <input type="text" name="nom" id="nom" required
                       value="<?php echo htmlspecialchars($user->getNom()); ?>">
            </div>

            <!-- Prénom -->
            <div>
                <label for="prenom">Prénom <span>*</span></label>
                <input type="text" name="prenom" id="prenom" required
                       value="<?php echo htmlspecialchars($user->getPrenom()); ?>">
            </div>

            <!-- Champs conditionnels (élève, prof, superviseur) -->
            <?php if (in_array($type, ['eleve', 'prof', 'superviseur'])): ?>
                <!-- Date de naissance -->
                <div>
                    <label for="date_naissance">Date de naissance <span>*</span></label>
                    <input type="date" name="date_naissance" id="date_naissance" required
                           value="<?php echo htmlspecialchars($user->getDateNaissance()); ?>">
                </div>

                <!-- Genre -->
                <div>
                    <label for="id_genre">Genre <span>*</span></label>
                    <select name="id_genre" id="id_genre" required>
                        <option value="">Choisir un genre...</option>
                        <?php if (isset($genres) && is_array($genres)): ?>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?php echo $genre->getId(); ?>" 
                                        <?php echo ($user->getIdGenre() == $genre->getId()) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($genre->getLabel()); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Contact -->
            <div>
                <label for="contact">Contact <span>*</span></label>
                <input type="text" name="contact" id="contact" required
                       value="<?php echo htmlspecialchars($user->getContact()); ?>">
            </div>

            <!-- Adresse -->
            <div>
                <label for="adresse">Adresse</label>
                <textarea name="adresse" id="adresse" rows="3"><?php echo htmlspecialchars($user->getAdresse()); ?></textarea>
            </div>

            <!-- Boutons -->
            <div>
                <a href="/users">Annuler</a>
                <button type="submit">Modifier l'utilisateur</button>
            </div>
        </form>
    </div>
</body>
</html>