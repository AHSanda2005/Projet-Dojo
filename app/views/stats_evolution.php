<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques globales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 90%;
            margin: 30px auto;
            max-width: 1200px;
        }
        .filters {
            margin: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-header {
            text-align: center;
            margin: 20px 0;
        }
        select {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="stats-header">
            <h1>Statistiques globales d'évolution des élèves</h1>
            <p>Moyenne des notes et participation par mois</p>
        </div>
        
        <div class="filters">
            <form method="get">
                <label for="year">Filtrer par année :</label>
                <select name="year" id="year" onchange="this.form.submit()">
                    <option value="">Toutes les années</option>
                    <?php foreach ($available_years as $year): ?>
                        <option value="<?= $year ?>" <?= $selected_year == $year ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        
        <div class="chart-container">
            <canvas id="globalEvolutionChart"></canvas>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const statsData = <?= json_encode($stats) ?>;
        const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        
        // Préparer les données
        const labels = months;
        const avgNotes = statsData.map(stat => stat.avg_note !== null ? parseFloat(stat.avg_note).toFixed(2) : null);
        const studentCounts = statsData.map(stat => stat.student_count);
        
        // Création du graphique
        const ctx = document.getElementById('globalEvolutionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Note moyenne',
                        data: avgNotes,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        yAxisID: 'y',
                        spanGaps: true // Permet de gérer les valeurs nulles
                    },
                    {
                        label: "Nombre d'élèves évalués",
                        data: studentCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        type: 'bar',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label === 'Note moyenne' && context.raw === null) {
                                    return label + ': Aucune donnée';
                                }
                                if (label) {
                                    label += ': ';
                                }
                                if (context.raw !== null) {
                                    label += context.raw;
                                }
                                return label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Statistiques globales - Année <?= $selected_year ?>'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Note moyenne'
                        },
                        min: 0,
                        max: 20
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: "Nombre d'élèves"
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        min: 0
                    }
                }
            }
        });
    });
</script>
</body>
</html>