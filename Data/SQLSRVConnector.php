<?php
class SQLSRVConnector
{
    private static $instance = null;
    private $connection;

    // Configura correctamente los detalles de la conexión
    private $host = 'DESKTOP-D5H41I4';  // Nombre del servidor
    private $username = null;           // Cambia si usas autenticación SQL
    private $password = null;           // Cambia si usas autenticación SQL
    private $database = 'TConsulting';  // Nombre de la base de datos

    private function __construct()
    {
        try {
            // Verifica que los datos de conexión sean válidos
            $dsn = "sqlsrv:Server={$this->host};Database={$this->database}";
            $this->connection = new PDO($dsn, $this->username, $this->password);

            // Configura el modo de errores para PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Muestra un mensaje de error si no se puede conectar
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    // Singleton para obtener una sola instancia de la conexión
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new SQLSRVConnector();
        }
        return self::$instance;
    }

    // Método para obtener la conexión activa
    public function getConnection()
    {
        return $this->connection;
    }
}


