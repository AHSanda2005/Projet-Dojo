<?php

namespace app\models\utilisateurModels;

use PDO;
use PDOException;

class Database {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function testConnection() {
        // Vérifier les drivers disponibles
        $availableDrivers = PDO::getAvailableDrivers();
        
        if (!in_array($this->config['driver'], $availableDrivers)) {
            return [
                'success' => false,
                'message' => 'Driver de base de données non disponible',
                'error' => "Le driver '{$this->config['driver']}' n'est pas installé",
                'available_drivers' => implode(', ', $availableDrivers),
                'database_type' => $this->config['driver'],
                'host' => $this->config['host'],
                'port' => $this->config['port'],
                'database_name' => $this->config['dbname'],
                'solution' => $this->getSolution($this->config['driver'])
            ];
        }

        try {
            $dsn = "{$this->config['driver']}:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['dbname']}";
            
            $pdo = new PDO(
                $dsn,
                $this->config['user'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            // Test simple query selon le type de base
            if ($this->config['driver'] === 'pgsql') {
                $stmt = $pdo->query("SELECT version() as version");
            } else {
                $stmt = $pdo->query("SELECT @@version as version");
            }
            $result = $stmt->fetch();

            return [
                'success' => true,
                'message' => 'Connexion réussie à la base de données',
                'database_version' => $result['version'] ?? 'Version inconnue',
                'database_type' => $this->config['driver'],
                'host' => $this->config['host'],
                'port' => $this->config['port'],
                'database_name' => $this->config['dbname'],
                'available_drivers' => implode(', ', $availableDrivers)
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur de connexion à la base de données',
                'error' => $e->getMessage(),
                'database_type' => $this->config['driver'],
                'host' => $this->config['host'],
                'port' => $this->config['port'],
                'database_name' => $this->config['dbname'],
                'available_drivers' => implode(', ', $availableDrivers),
                'solution' => $this->getSolution($this->config['driver'])
            ];
        }
    }

    private function getSolution($driver) {
        $solutions = [
            'pgsql' => 'Installer l\'extension PostgreSQL pour PHP : sudo apt-get install php-pgsql (Ubuntu/Debian) ou activer extension=pdo_pgsql dans php.ini',
            'mysql' => 'Installer l\'extension MySQL pour PHP : sudo apt-get install php-mysql (Ubuntu/Debian) ou activer extension=pdo_mysql dans php.ini',
            'sqlite' => 'L\'extension SQLite est généralement incluse par défaut dans PHP'
        ];
        
        return $solutions[$driver] ?? 'Vérifier que l\'extension PDO pour ce driver est installée et activée';
    }

    public function getConnection() {
        try {
            $dsn = "{$this->config['driver']}:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['dbname']}";
            
            return new PDO(
                $dsn,
                $this->config['user'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException("Erreur de connexion : " . $e->getMessage());
        }
    }
}

?>