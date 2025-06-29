<div class="parent-eleve-management">
    <div class="page-header">
        <h1>
            <i class="fas fa-link"></i> Gestion des relations Parent-Élève
        </h1>
        <p class="text-muted">Gérez les associations entre parents et élèves</p>
    </div>
    
    <?php if (isset($success) && $success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <div class="actions mb-4">
        <div class="row">
            <div class="col-md-6">
                <a href="/parent-eleve/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer une nouvelle relation
                </a>
            </div>
            <div class="col-md-6">
                <form method="GET" action="/parent-eleve" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Rechercher par nom d'élève ou parent..." 
                           value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="/parent-eleve" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <?php if (!empty($relations)): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Relations Parent-Élève
                    <span class="badge bg-secondary"><?php echo count($relations); ?></span>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <i class="fas fa-user-graduate text-primary"></i> Élève
                                </th>
                                <th>
                                    <i class="fas fa-user-friends text-success"></i> Parent
                                </th>
                                <th>
                                    <i class="fas fa-cogs"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($relations as $relation): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($relation['eleve_nom'] . ' ' . $relation['eleve_prenom']); ?></strong>
                                        <br>
                                        <small class="text-muted">ID: <?php echo $relation['id_eleve']; ?></small>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($relation['parent_nom'] . ' ' . $relation['parent_prenom']); ?></strong>
                                        <br>
                                        <small class="text-muted">ID: <?php echo $relation['id_parent']; ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/parent-eleve/link/<?php echo $relation['id_eleve']; ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Ajouter un autre parent">
                                                <i class="fas fa-plus"></i> Ajouter parent
                                            </a>
                                            <a href="/parent-eleve/unlink/<?php echo $relation['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               title="Supprimer cette relation"
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette relation parent-élève ?');">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h5>Aucune relation parent-élève trouvée</h5>
            <p class="mb-3">
                <?php if (!empty($search)): ?>
                    Aucun résultat pour votre recherche "<?php echo htmlspecialchars($search); ?>"
                <?php else: ?>
                    Commencez par créer une relation entre un parent et un élève
                <?php endif; ?>
            </p>
            <a href="/parent-eleve/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer la première relation
            </a>
        </div>
    <?php endif; ?>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informations
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Un élève peut avoir plusieurs parents
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Un parent peut avoir plusieurs enfants
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Les relations sont bidirectionnelles
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle"></i> Besoin d'aide ?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Si vous ne trouvez pas l'élève ou le parent souhaité, 
                        vous devez d'abord les créer dans la gestion des utilisateurs.
                    </p>
                    <a href="/users/create" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Créer un utilisateur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>