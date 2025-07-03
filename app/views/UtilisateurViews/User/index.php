<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
</head>
<body>
    <div>
        <h1>Gestion des Utilisateurs</h1>
        
        <!-- Messages de succès/erreur -->
        <?php if (isset($success) && $success): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error) && $error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($message) && $message): ?>
            <div class="info-message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Barre d'actions -->
        <div class="actions-bar">
            <a href="/users/create">Ajouter un utilisateur</a>
            <a href="/parent-eleve">Gestion relation parent élève</a>
            
            <!-- Formulaire de recherche -->
            <form method="GET" action="/users">
                <input type="hidden" name="type" value="<?php echo htmlspecialchars($currentType); ?>">
                <input type="text" name="search" placeholder="Rechercher..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Rechercher</button>
                <?php if (!empty($search)): ?>
                    <a href="/users?type=<?php echo htmlspecialchars($currentType); ?>">Effacer</a>
                <?php endif; ?>
            </form>
            
            <!-- Filtres par type -->
            <div class="type-filters">
                <a href="/users?type=all" <?php echo $currentType === 'all' ? 'class="active"' : ''; ?>>
                    Tous (<?php echo $totalUsers; ?>)
                </a>
                <a href="/users?type=eleve" <?php echo $currentType === 'eleve' ? 'class="active"' : ''; ?>>
                    Élèves
                </a>
                <a href="/users?type=prof" <?php echo $currentType === 'prof' ? 'class="active"' : ''; ?>>
                    Professeurs
                </a>
                <a href="/users?type=superviseur" <?php echo $currentType === 'superviseur' ? 'class="active"' : ''; ?>>
                    Superviseurs
                </a>
                <a href="/users?type=parent" <?php echo $currentType === 'parent' ? 'class="active"' : ''; ?>>
                    Parents
                </a>
            </div>
        </div>

        <!-- Affichage des utilisateurs -->
        <?php if ($currentType === 'all'): ?>
            <!-- Affichage groupé pour tous les types -->
            
            <!-- Élèves -->
            <?php if (!empty($users['eleves'])): ?>
                <h2>Élèves (<?php echo count($users['eleves']); ?>)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users['eleves'] as $eleve): ?>
                            <tr>
                                <td><?php echo $eleve->getIdEleve(); ?></td>
                                <td><?php echo htmlspecialchars($eleve->getNom()); ?></td>
                                <td><?php echo htmlspecialchars($eleve->getPrenom()); ?></td>
                                <td><?php echo htmlspecialchars($eleve->getDateNaissance()); ?></td>
                                <td><?php echo htmlspecialchars($eleve->getContact()); ?></td>
                                <td><?php echo htmlspecialchars($eleve->getAdresse()); ?></td>
                                <td>
                                    <a href="/users/edit/eleve/<?php echo $eleve->getIdEleve(); ?>">Modifier</a>
                                    <a href="/users/delete/eleve/<?php echo $eleve->getIdEleve(); ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Professeurs -->
            <?php if (!empty($users['profs'])): ?>
                <h2>Professeurs (<?php echo count($users['profs']); ?>)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users['profs'] as $prof): ?>
                            <tr>
                                <td><?php echo $prof->getIdProf(); ?></td>
                                <td><?php echo htmlspecialchars($prof->getNom()); ?></td>
                                <td><?php echo htmlspecialchars($prof->getPrenom()); ?></td>
                                <td><?php echo htmlspecialchars($prof->getDateNaissance()); ?></td>
                                <td><?php echo htmlspecialchars($prof->getContact()); ?></td>
                                <td><?php echo htmlspecialchars($prof->getAdresse()); ?></td>
                                <td>
                                    <a href="/users/edit/prof/<?php echo $prof->getIdProf(); ?>">Modifier</a>
                                    <a href="/users/delete/prof/<?php echo $prof->getIdProf(); ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Superviseurs -->
            <?php if (!empty($users['superviseurs'])): ?>
                <h2>Superviseurs (<?php echo count($users['superviseurs']); ?>)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users['superviseurs'] as $superviseur): ?>
                            <tr>
                                <td><?php echo $superviseur->getIdSuperviseur(); ?></td>
                                <td><?php echo htmlspecialchars($superviseur->getNom()); ?></td>
                                <td><?php echo htmlspecialchars($superviseur->getPrenom()); ?></td>
                                <td><?php echo htmlspecialchars($superviseur->getDateNaissance()); ?></td>
                                <td><?php echo htmlspecialchars($superviseur->getContact()); ?></td>
                                <td><?php echo htmlspecialchars($superviseur->getAdresse()); ?></td>
                                <td>
                                    <a href="/users/edit/superviseur/<?php echo $superviseur->getIdSuperviseur(); ?>">Modifier</a>
                                    <a href="/users/delete/superviseur/<?php echo $superviseur->getIdSuperviseur(); ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Parents -->
            <?php if (!empty($users['parents'])): ?>
                <h2>Parents (<?php echo count($users['parents']); ?>)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users['parents'] as $parent): ?>
                            <tr>
                                <td><?php echo $parent->getIdParent(); ?></td>
                                <td><?php echo htmlspecialchars($parent->getNom()); ?></td>
                                <td><?php echo htmlspecialchars($parent->getPrenom()); ?></td>
                                <td><?php echo htmlspecialchars($parent->getContact()); ?></td>
                                <td><?php echo htmlspecialchars($parent->getAdresse()); ?></td>
                                <td>
                                    <a href="/users/edit/parent/<?php echo $parent->getIdParent(); ?>">Modifier</a>
                                    <a href="/users/delete/parent/<?php echo $parent->getIdParent(); ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php else: ?>
            <!-- Affichage pour un type spécifique -->
            <?php if (!empty($users)): ?>
                <h2>
                    <?php 
                    $typeLabels = [
                        'eleve' => 'Élèves',
                        'prof' => 'Professeurs', 
                        'superviseur' => 'Superviseurs',
                        'parent' => 'Parents'
                    ];
                    echo $typeLabels[$currentType] ?? 'Utilisateurs';
                    ?>
                    (<?php echo count($users); ?>)
                </h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <?php if ($currentType !== 'parent'): ?>
                                <th>Date de naissance</th>
                            <?php endif; ?>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?php 
                                    switch($currentType) {
                                        case 'eleve': echo $user->getIdEleve(); break;
                                        case 'prof': echo $user->getIdProf(); break;
                                        case 'superviseur': echo $user->getIdSuperviseur(); break;
                                        case 'parent': echo $user->getIdParent(); break;
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($user->getNom()); ?></td>
                                <td><?php echo htmlspecialchars($user->getPrenom()); ?></td>
                                <?php if ($currentType !== 'parent'): ?>
                                    <td><?php echo htmlspecialchars($user->getDateNaissance()); ?></td>
                                <?php endif; ?>
                                <td><?php echo htmlspecialchars($user->getContact()); ?></td>
                                <td><?php echo htmlspecialchars($user->getAdresse()); ?></td>
                                <td>
                                    <?php 
                                    $userId = '';
                                    switch($currentType) {
                                        case 'eleve': $userId = $user->getIdEleve(); break;
                                        case 'prof': $userId = $user->getIdProf(); break;
                                        case 'superviseur': $userId = $user->getIdSuperviseur(); break;
                                        case 'parent': $userId = $user->getIdParent(); break;
                                    }
                                    ?>
                                    <a href="/users/edit/<?php echo $currentType; ?>/<?php echo $userId; ?>">Modifier</a>
                                    <a href="/users/delete/<?php echo $currentType; ?>/<?php echo $userId; ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun utilisateur trouvé.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>