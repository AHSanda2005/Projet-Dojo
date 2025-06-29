<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Base de données</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .status-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .status-success {
            border-left: 4px solid #4CAF50;
        }
        .status-error {
            border-left: 4px solid #f44336;
        }
        .status-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .status-message {
            margin-bottom: 15px;
        }
        .status-details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 13px;
            line-height: 1.4;
        }
        .success { color: #4CAF50; }
        .error { color: #f44336; }
        .solution-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin-top: 15px;
        }
        .solution-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
        }
        .drivers-info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 4px;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<div class="container">
    <a href="/genres">Gérer les Genres</a>
    <a href="/users">Users</a>
    <h1>Test de Connexion Base de Données</h1>
    
    <!-- Statut de la base de données -->
    <div class="status-card <?= $db_status['success'] ? 'status-success' : 'status-error' ?>">
        <div class="status-title">
            <?= $db_status['success'] ? '✅' : '❌' ?> Base de données
        </div>
        <div class="status-message">
            <strong>Statut :</strong> 
            <span class="<?= $db_status['success'] ? 'success' : 'error' ?>">
                <?= htmlspecialchars($db_status['message']) ?>
            </span>
        </div>
        <div class="status-details">
            <strong>Détails de connexion :</strong><br>
            <strong>Type :</strong> <?= htmlspecialchars($db_status['database_type']) ?><br>
            <strong>Hôte :</strong> <?= htmlspecialchars($db_status['host']) ?>:<?= htmlspecialchars($db_status['port']) ?><br>
            <strong>Base :</strong> <?= htmlspecialchars($db_status['database_name']) ?><br>
            
            <?php if ($db_status['success'] && isset($db_status['database_version'])): ?>
                <strong>Version :</strong> <?= htmlspecialchars($db_status['database_version']) ?><br>
            <?php endif; ?>
            
            <?php if (isset($db_status['available_drivers'])): ?>
                <div class="drivers-info">
                    <strong>Drivers PDO disponibles :</strong> <?= htmlspecialchars($db_status['available_drivers']) ?>
                </div>
            <?php endif; ?>
            
            <?php if (!$db_status['success'] && isset($db_status['error'])): ?>
                <br><strong>Erreur :</strong> <span class="error"><?= htmlspecialchars($db_status['error']) ?></span>
            <?php endif; ?>
        </div>
        
        <?php if (!$db_status['success'] && isset($db_status['solution'])): ?>
            <div class="solution-box">
                <div class="solution-title">💡 Solution :</div>
                <?= htmlspecialchars($db_status['solution']) ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if (!$db_status['success']): ?>
        <div class="status-card">
            <div class="status-title">🔧 Instructions de dépannage</div>
            <div class="status-details">
                <strong>Pour installer l'extension PostgreSQL :</strong><br><br>
                
                <strong>Ubuntu/Debian :</strong><br>
                <code>sudo apt-get update</code><br>
                <code>sudo apt-get install php-pgsql</code><br>
                <code>sudo systemctl restart apache2</code><br><br>
                
                <strong>CentOS/RHEL :</strong><br>
                <code>sudo yum install php-pgsql</code><br>
                <code>sudo systemctl restart httpd</code><br><br>
                
                <strong>Windows (XAMPP) :</strong><br>
                1. Ouvrir le fichier <code>php.ini</code><br>
                2. Décommenter la ligne : <code>extension=pdo_pgsql</code><br>
                3. Redémarrer Apache<br><br>
                
                <strong>Vérification :</strong><br>
                Créer un fichier PHP avec <code>&lt;?php phpinfo(); ?&gt;</code> et vérifier la section PDO.
            </div>
        </div>
    <?php endif; ?>
</div>    
</body>

</html>