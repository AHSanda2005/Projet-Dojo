<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Genre - Dojo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 300;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .breadcrumb {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .content {
            padding: 40px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }
        
        .form-input.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }
        
        .form-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            min-width: 120px;
            justify-content: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .form-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        
        .required {
            color: #dc3545;
        }
        
        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Accueil</a> > <a href="/genres">Genres</a> > <strong>Créer un genre</strong>
        </div>
        
        <div class="header">
            <h1>➕ Créer un Genre</h1>
            <p>Ajoutez un nouveau genre au système</p>
        </div>
        
        <div class="content">
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <span>❌</span>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>
            
            <div class="form-card">
                <form method="POST" action="/genres/store">
                    <div class="form-group">
                        <label for="label" class="form-label">
                            Nom du Genre <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="label" 
                            name="label" 
                            class="form-input <?= isset($error) ? 'error' : '' ?>"
                            value="<?= htmlspecialchars($old_data['label'] ?? '') ?>"
                            placeholder="Ex: Masculin, Féminin, Autre..."
                            required
                            maxlength="255"
                        >
                        <div class="form-help">
                            Maximum 255 caractères. Ce champ est obligatoire.
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <a href="/genres" class="btn btn-secondary">
                            <span>❌</span>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span>💾</span>
                            Créer le genre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-focus sur le champ de saisie
        document.getElementById('label').focus();
        
        // Validation côté client
        document.querySelector('form').addEventListener('submit', function(e) {
            const label = document.getElementById('label').value.trim();
            
            if (label === '') {
                e.preventDefault();
                alert('Le nom du genre est obligatoire');
                document.getElementById('label').focus();
                return false;
            }
            
            if (label.length > 255) {
                e.preventDefault();
                alert('Le nom du genre ne peut pas dépasser 255 caractères');
                document.getElementById('label').focus();
                return false;
            }
        });
    </script>
</body>
</html>