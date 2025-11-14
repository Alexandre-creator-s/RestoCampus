<?php
class Db {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = getenv('DB_HOST') ?: 'localhost';
        $dbname = getenv('DB_NAME') ?: 'restocampus';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: 'root';
        $charset = 'utf8';

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset",
                $user,    
                $pass        
            );
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
