<?php
class SQLSRVConnector {
    private static $instance = null;
    private $connection;

    private $host = 'JSUHULA\UMGDB2';
    private $username = 'sqladmin';
    private $password = '59548601Josias';
    private $database = 'TConsulting';
    private function __construct() {
        try {
            $dsn = "sqlsrv:Server={$this->host};Database={$this->database}";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new SQLSRVConnector();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

