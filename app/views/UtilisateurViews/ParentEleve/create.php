<div class="create-parent-eleve">
    <div class="page-header">
        <h1>
            <i class="fas fa-link"></i> Créer une relation Parent-Élève
        </h1>
        <p class="text-muted">Associez un parent à un ou plusieurs élèves</p>
    </div>
    
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Erreur !</strong> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus"></i> Nouvelle relation
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/parent-eleve/store" id="createRelationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_eleve" class="form-label fw-bold">
                                        <i class="fas fa-user-graduate text-primary"></i> Sélectionner un élève *
                                    </label>
                                    <select name="id_eleve" id="id_eleve" class="form-select" required>
                                        <option value="">-- Choisir un élève --</option>
                                        <?php foreach ($eleves as $eleve): ?>
                                            <option value="<?php echo $eleve->getIdEleve(); ?>"
                                                    <?php echo (isset($old_data['id_eleve']) && $old_data['id_eleve'] == $eleve->getIdEleve()) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($eleve->getNom() . ' ' . $eleve->getPrenom()); ?>
                                                (ID: <?php echo $eleve->getIdEleve(); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        L'élève à qui vous voulez associer un parent
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_parent" class="form-label fw-bold">
                                        <i class="fas fa-user-friends text-success"></i> Sélectionner un parent *
                                    </label>
                                    <select name="id_parent" id="id_parent" class="form-select" required>
                                        <option value="">-- Choisir un parent --</option>
                                        <?php foreach ($parents as $parent): ?>
                                            <option value="<?php echo $parent->getIdParent(); ?>"
                                                    <?php echo (isset($old_data['id_parent']) && $old_data['id_parent'] == $parent->getIdParent()) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($parent->getNom() . ' ' . $parent->getPrenom()); ?>
                                                <?php if ($parent->getContact()): ?>
                                                    - <?php echo htmlspecialchars($parent->getContact()); ?>
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        Le parent à associer à l'élève sélectionné
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Information :</strong> Un élève peut avoir plusieurs parents. 
                                Vous pourrez ajouter d'autres parents à cet élève après la création de cette relation.
                            </div>
                        </div>
                        
                        <div class="form-actions text-center">
                            <button type="submit" class="btn btn-success btn-lg me-3">
                                <i class="fas fa-save"></i> Créer la relation
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
                        <i class="fas fa-lightbulb"></i> Aide
                    </h6>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-question-circle text-primary"></i> Comment ça marche ?</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Sélectionnez d'abord un élève
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Choisissez ensuite un parent
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Validez pour créer la relation
                        </li>
                    </ul>
                    
                    <hr>
                    
                    <h6><i class="fas fa-users text-warning"></i> Relations multiples</h6>
                    <p class="small text-muted">
                        Un élève peut avoir plusieurs parents (père, mère, tuteur, etc.). 
                        Après avoir créé cette relation, vous pourrez en ajouter d'autres.
                    </p>
                    
                    <hr>
                    
                    <h6><i class="fas fa-plus text-success"></i> Utilisateurs manquants ?</h6>
                    <div class="d-grid">
                        <a href="/users/create" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user-plus"></i> Ajouter un utilisateur
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-primary"><?php echo count($eleves); ?></h4>
                                <small class="text-muted">Élèves</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-success"><?php echo count($parents); ?></h4>
                                <small class="text-muted">Parents</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createRelationForm');
    const eleveSelect = document.getElementById('id_eleve');
    const parentSelect = document.getElementById('id_parent');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (!eleveSelect.value) {
            eleveSelect.classList.add('is-invalid');
            isValid = false;
        } else {
            eleveSelect.classList.remove('is-invalid');
        }
        
        if (!parentSelect.value) {
            parentSelect.classList.add('is-invalid');
            isValid = false;
        } else {
            parentSelect.classList.remove('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Veuillez sélectionner un élève et un parent.');
        }
    });
    
    // Amélioration de l'UX avec Select2 si disponible
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#id_eleve, #id_parent').select2({
            theme: 'bootstrap4',
            placeholder: function() {
                return $(this).data('placeholder');
            }
        });
    }
});
</script>