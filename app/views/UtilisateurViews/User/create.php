<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <!-- En-tête -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Créer un Utilisateur</h1>
            <a href="/users" class="text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>

        <!-- Message d'erreur -->
        <?php if (isset($error) && $error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i><?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form method="POST" action="/users/store" class="space-y-6">
            <!-- Sélection du type d'utilisateur -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Type d'utilisateur <span class="text-red-500">*</span>
                </label>
                <select name="type" id="type" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="toggleFields()">
                    <option value="">Choisir un type...</option>
                    <option value="eleve" <?php echo (isset($old_data['type']) && $old_data['type'] === 'eleve') ? 'selected' : ''; ?>>
                        Élève
                    </option>
                    <option value="prof" <?php echo (isset($old_data['type']) && $old_data['type'] === 'prof') ? 'selected' : ''; ?>>
                        Professeur
                    </option>
                    <option value="superviseur" <?php echo (isset($old_data['type']) && $old_data['type'] === 'superviseur') ? 'selected' : ''; ?>>
                        Superviseur
                    </option>
                    <option value="parent" <?php echo (isset($old_data['type']) && $old_data['type'] === 'parent') ? 'selected' : ''; ?>>
                        Parent
                    </option>
                </select>
            </div>

            <!-- Informations personnelles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" id="nom" required
                           value="<?php echo htmlspecialchars($old_data['nom'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nom de famille">
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="prenom" id="prenom" required
                           value="<?php echo htmlspecialchars($old_data['prenom'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Prénom">
                </div>
            </div>

            <!-- Champs conditionnels (élève, prof, superviseur) -->
            <div id="conditional-fields" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date de naissance -->
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-2">
                            Date de naissance <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_naissance" id="date_naissance"
                               value="<?php echo htmlspecialchars($old_data['date_naissance'] ?? ''); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="id_genre" class="block text-sm font-medium text-gray-700 mb-2">
                            Genre <span class="text-red-500">*</span>
                        </label>
                        <select name="id_genre" id="id_genre" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Choisir un genre...</option>
                            <?php if (isset($genres) && is_array($genres)): ?>
                                <?php foreach ($genres as $genre): ?>
                                    <option value="<?php echo $genre->getId(); ?>" 
                                            <?php echo (isset($old_data['id_genre']) && $old_data['id_genre'] == $genre->getId()) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($genre->getLabel()); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">
                    Contact <span class="text-red-500">*</span>
                </label>
                <input type="text" name="contact" id="contact" required
                       value="<?php echo htmlspecialchars($old_data['contact'] ?? ''); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Numéro de téléphone ou email">
            </div>

            <!-- Adresse -->
            <div>
                <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                    Adresse
                </label>
                <textarea name="adresse" id="adresse" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Adresse complète (optionnel)"><?php echo htmlspecialchars($old_data['adresse'] ?? ''); ?></textarea>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="/users" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium transition-colors">
                    <i class="fas fa-save mr-2"></i>Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleFields() {
    const typeSelect = document.getElementById('type');
    const conditionalFields = document.getElementById('conditional-fields');
    const dateField = document.getElementById('date_naissance');
    const genreField = document.getElementById('id_genre');
    
    if (['eleve', 'prof', 'superviseur'].includes(typeSelect.value)) {
        conditionalFields.style.display = 'block';
        dateField.required = true;
        genreField.required = true;
    } else {
        conditionalFields.style.display = 'none';
        dateField.required = false;
        genreField.required = false;
        dateField.value = '';
        genreField.value = '';
    }
}

// Initialiser l'affichage au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
});
</script>