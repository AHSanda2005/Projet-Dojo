<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Genres - Dojo</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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

        .content {
            padding: 30px;
        }

        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
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
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex: 1;
            max-width: 400px;
        }

        .form-input {
            flex: 1;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .stats {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .stats h3 {
            color: #495057;
            margin-bottom: 5px;
        }

        .stats .number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            text-align: left;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        td {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }

        tr:hover td {
            background-color: #f8f9fa;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            font-weight: 300;
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

        @media (max-width: 768px) {
            .actions-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-form {
                max-width: none;
            }

            .actions {
                flex-direction: column;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
                border-radius: 8px;
                overflow: hidden;
            }

            td {
                border: none;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                content: attr(data-label) ": ";
                position: absolute;
                left: 6px;
                width: 45%;
                font-weight: bold;
                color: #667eea;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Accueil</a> > <strong>Gestion des Genres</strong>
        </div>

        <div class="header">
            <h1>🎭 Gestion des Genres</h1>
            <p>Gérez les différents genres utilisés dans le système</p>
        </div>

        <div class="content">
            <!-- Messages d'alerte -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <span>✅</span>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <span>❌</span>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($message)): ?>
                <div class="alert alert-info">
                    <span>🔍</span>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>

            <!-- Statistiques -->
            <div class="stats">
                <h3>Total des genres</h3>
                <div class="number"><?= $totalGenres ?></div>
            </div>

            <!-- Barre d'actions -->
            <div class="actions-bar">
                <a href="/genres/create" class="btn btn-primary">
                    <span>➕</span>
                    Ajouter un genre
                </a>

                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Rechercher un genre..."
                        value="<?= htmlspecialchars($search) ?>" class="form-input">
                    <button type="submit" class="btn btn-secondary">
                        <span>🔍</span>
                        Rechercher
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="/genres" class="btn btn-secondary">
                            <span>❌</span>
                            Effacer
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Tableau des genres -->
            <?php if (empty($genres)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h3><?= !empty($search) ? 'Aucun résultat trouvé' : 'Aucun genre trouvé' ?></h3>
                    <p><?= !empty($search) ? 'Essayez avec des termes différents' : 'Commencez par ajouter votre premier genre' ?>
                    </p>
                    <?php if (empty($search)): ?>
                        <br>
                        <a href="/genres/create" class="btn btn-primary">
                            <span>➕</span>
                            Créer le premier genre
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Genre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($genres as $genre): ?>
                                <tr>
                                    <td data-label="ID"><?= htmlspecialchars($genre->getId()) ?></td>
                                    <td data-label="Nom du Genre">
                                        <strong><?= htmlspecialchars($genre->getLabel()) ?></strong>
                                    </td>
                                    <td data-label="Actions">
                                        <div class="actions">
                                            <a href="/genres/edit/<?= $genre->getId() ?>" class="btn btn-secondary btn-sm">
                                                <span>✏️</span>
                                                Modifier
                                            </a>
                                            <a href="/genres/delete/<?= $genre->getId() ?>" class="btn btn-danger btn-sm">
                                                <span>🗑️</span>
                                                Supprimer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>