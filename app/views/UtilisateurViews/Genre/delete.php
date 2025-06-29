<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer le Genre - Dojo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
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

        .warning-card {
            background: #fff3cd;
            border: 2px solid #ffeaa7;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .warning-icon {
            font-size: 4em;
            margin-bottom: 15px;
        }

        .warning-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
        }

        .warning-message {
            color: #664d03;
            line-height: 1.6;
        }

        .info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .info-card h3 {
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
        }

        .info-value {
            font-weight: bold;
            color: #495057;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
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
            min-width: 140px;
            justify-content: center;
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

        .danger-zone {
            background: #f8d7da;
            border: 2px solid #f5c6cb;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }

        .danger-zone h3 {
            color: #721c24;
            margin-bottom: 15px;
        }

        .danger-zone p {
            color: #721c24;
            margin-bottom: 20px;
            line-height: 1.6;
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

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Accueil</a> > <a href="/genres">Genres</a> > <strong>Supprimer:
                <?= htmlspecialchars($genre->getLabel()) ?></strong>
        </div>

        <div class="header">
            <h1>🗑️ Supprimer le Genre</h1>
            <p>Confirmation de suppression</p>
        </div>

        <div class="content">
            <div class="warning-card">
                <div class="warning-icon">⚠️</div>
                <div class="warning-title">Attention !</div>
                <div class="warning-message">
                    Vous êtes sur le point de supprimer définitivement ce genre.<br>
                    Cette action est <strong>irréversible</strong>.
                </div>
            </div>

            <div class="info-card">
                <h3>📋 Informations du genre à supprimer</h3>
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value"><?= htmlspecialchars($genre->getId()) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nom:</span>
                    <span class="info-value"><?= htmlspecialchars($genre->getLabel()) ?></span>
                </div>
            </div>

            <div class="danger-zone">
                <h3>🚨 Zone de danger</h3>
                <p>
                    <strong>La suppression échouera si ce genre est utilisé</strong> par des superviseurs,
                    professeurs ou élèves dans le système.
                </p>
                <p>
                    Assurez-vous que ce genre n'est plus utilisé avant de procéder à la suppression.
                </p>

                <div class="form-actions">
                    <a href="/genres" class="btn btn-secondary">
                        <span>❌</span>
                        Annuler
                    </a>
                    <form method="POST" action="/genres/destroy/<?= $genre->getId() ?>" style="display: inline;">
                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">
                            <span>🗑️</span>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            const genreName = '<?= addslashes($genre->getLabel()) ?>';

            return confirm(
                `Êtes-vous absolument sûr(e) de vouloir supprimer le genre "${genreName}" ?\n\n` +
                'Cette action est IRRÉVERSIBLE !\n\n' +
                'Cliquez sur "OK" pour confirmer la suppression ou "Annuler" pour revenir en arrière.'
            );
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                window.location.href = '/genres';
            }
        });

        document.querySelector('.btn-secondary').focus();
    </script>
</body>

</html>