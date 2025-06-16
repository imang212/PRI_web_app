<?php
// database.php - Připojení k databázi
class Database {
    private $host = 'postgres_db_exoplanets';
    private $db = 'app';
    private $user = 'admin';
    private $pass = 'admin';
    private $charset = 'utf8';
    private $pdo;

    public function __construct() {
        $dsn = "pgsql:host=$this->host;dbname=$this->db;charset=$this->charset";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function getConnection() {
        return $this->pdo;
    }
}
?>