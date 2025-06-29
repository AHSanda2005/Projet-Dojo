<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Utilisateur</title>
</head>
<body>
    <div>
        <h1>Confirmer la suppression</h1>
        
        <a href="/users">← Retour à la liste</a>

        <!-- Avertissement -->
        <div class="warning-message">
            <h2>⚠️ Attention</h2>
            <p>Vous êtes sur le point de supprimer définitivement cet utilisateur. Cette action est irréversible.</p>
        </div>

        <!-- Informations de l'utilisateur à supprimer -->
        <div class="user-info">
            <h3>Informations de l'utilisateur</h3>
            
            <table>
                <tr>
                    <td><strong>Type :</strong></td>
                    <td>
                        <?php 
                        $typeLabels = [
                            'eleve' => 'Élève',
                            'prof' => 'Professeur', 
                            'superviseur' => 'Superviseur',
                            'parent' => 'Parent'
                        ];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>ID :</strong></td>
                    <td>
                        <?php 
                        switch($type) {
                            case 'eleve': echo $user->getIdEleve(); break;
                            case 'prof': echo $user->getIdProf(); break;
                            case 'superviseur': echo $user->getIdSuperviseur(); break;
                            case 'parent': echo $user->getIdParent(); break;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Nom :</strong></td>
                    <td><?php echo htmlspecialchars($user->getNom()); ?></td>
                </tr>
                <tr>
                    <td><strong>Prénom :</strong></td>
                    <td><?php echo htmlspecialchars($user->getPrenom()); ?></td>
                </tr>
                <?php if (in_array($type, ['eleve', 'prof', 'superviseur'])): ?>
                    <tr>
                        <td><strong>Date de naissance :</strong></td>
                        <td><?php echo htmlspecialchars($user->getDateNaissance()); ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td><strong>Contact :</strong></td>
                    <td><?php echo htmlspecialchars($user->getContact()); ?></td>
                </tr>
                <tr>
                    <td><strong>Adresse :</strong></td>
                    <td><?php echo htmlspecialchars($user->getAdresse()); ?></td>
                </tr>
            </table>
        </div>

        <!-- Formulaire de confirmation -->
        <div class="confirmation-actions">
            <h3>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</h3>
            
            <div class="action-buttons">
                <!-- Bouton Annuler -->
                <a href="/users" class="cancel-button">
                    Non, annuler
                </a>
                
                <!-- Formulaire de suppression -->
                <form method="POST" action="/users/destroy/<?php echo htmlspecialchars($type); ?>/<?php echo $user->{'getId' . ucfirst($type)}(); ?>" style="display: inline;">
                    <button type="submit" class="delete-button" onclick="return confirm('Êtes-vous absolument certain de vouloir supprimer cet utilisateur ? Cette action ne peut pas être annulée.');">
                        Oui, supprimer définitivement
                    </button>
                </form>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="additional-info">
            <h4>Informations importantes :</h4>
            <ul>
                <li>La suppression est définitive et ne peut pas être annulée</li>
                <li>Toutes les données associées à cet utilisateur seront perdues</li>
                <?php if ($type === 'eleve'): ?>
                    <li>L'élève sera retiré de tous les cours et évaluations</li>
                <?php elseif ($type === 'prof'): ?>
                    <li>Le professeur sera retiré de tous les cours qu'il enseigne</li>
                <?php elseif ($type === 'superviseur'): ?>
                    <li>Le superviseur sera retiré de toutes ses affectations</li>
                <?php elseif ($type === 'parent'): ?>
                    <li>Le parent sera dissocié de tous ses enfants</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
    // Confirmation supplémentaire avant soumission
    document.querySelector('form').addEventListener('submit', function(e) {
        const userType = '<?php echo $typeLabels[$type] ?? 'utilisateur'; ?>';
        const userName = '<?php echo htmlspecialchars($user->getPrenom() . ' ' . $user->getNom()); ?>';
        
        if (!confirm(`DERNIÈRE CONFIRMATION:\n\nVoulez-vous vraiment supprimer ${userType.toLowerCase()} "${userName}" ?\n\nCette action est DÉFINITIVE et IRRÉVERSIBLE.`)) {
            e.preventDefault();
        }
    });
    </script>
</body>
</html>