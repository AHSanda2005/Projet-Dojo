<div class="link-parent-eleve">
    <div class="page-header">
        <h1>
            <i class="fas fa-link"></i> Lier un parent à l'élève: 
            <span class="text-primary"><?php echo htmlspecialchars($eleve->getNom() . ' ' . $eleve->getPrenom()); ?></span>
        </h1>
        <p class="text-muted">Ajouter un nouveau parent à cet élève</p>
    </div>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus"></i> Ajouter un parent
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/parent-eleve/link/<?php echo $eleve->getIdEleve(); ?>">
                        <div class="form-group mb-4">
                            <label for="id_parent" class="form-label fw-bold">
                                <i class="fas fa-user-friends text-success"></i> Sélectionner un parent *
                            </label>
                            <select name="id_parent" id="id_parent" class="form-select" required>
                                <option value="">-- Sélectionner un parent --</option>
                                <?php foreach ($parents as $parent): ?>
                                    <option value="<?php echo $parent->getIdParent(); ?>">
                                        <?php echo htmlspecialchars($parent->getNom() . ' ' . $parent->getPrenom()); ?>
                                        <?php if ($parent->getContact()): ?>
                                            - <?php echo htmlspecialchars($parent->getContact()); ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">
                                Choisissez le parent à associer à cet élève
                            </div>
                        </div>
                        
                        <div class="form-actions text-center">
                            <button type="submit" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-link"></i> Lier le parent
                            </button>
                            <a href="/parent-eleve" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informations élève
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="text-primary">
                        <i class="fas fa-user-graduate"></i> 
                        <?php echo htmlspecialchars($eleve->getNom() . ' ' . $eleve->getPrenom()); ?>
                    </h6>
                    <p class="text-muted small">ID: <?php echo $eleve->getIdEleve(); ?></p>
                    
                    <?php if ($eleve->getContact()): ?>
                        <p class="mb-1">
                            <i class="fas fa-phone text-success"></i> 
                            <?php echo htmlspecialchars($eleve->getContact()); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ($eleve->getAdresse()): ?>
                        <p class="mb-1">
                            <i class="fas fa-map-marker-alt text-warning"></i> 
                            <?php echo htmlspecialchars($eleve->getAdresse()); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($existingParents)): ?>
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-users"></i> Parents déjà liés
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (count($existingParents) > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($existingParents as $parent): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <i class="fas fa-user-friends text-success me-2"></i>
                                            <strong><?php echo htmlspecialchars($parent['nom'] . ' ' . $parent['prenom']); ?></strong>
                                        </div>
                                        <span class="badge bg-success">Lié</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-info-circle"></i> 
                                Aucun parent lié actuellement
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle"></i> Aide
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Vous pouvez ajouter autant de parents que nécessaire à un élève 
                        (père, mère, tuteur légal, etc.).
                    </p>
                    <p class="small text-muted mb-0">
                        Si le parent souhaité n'apparaît pas dans la liste, 
                        vous devez d'abord le créer dans la gestion des utilisateurs.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>