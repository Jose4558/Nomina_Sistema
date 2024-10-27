<?php
class SQLSRVConnector
{
    private static $instance = null;
    private $connection;

    // Detalles de la conexión
    private $host;          // Nombre del servidor
    private $username;      // Cambia si usas autenticación SQL
    private $password;      // Cambia si usas autenticación SQL
    private $database;      // Nombre de la base de datos

    // Constructor privado para establecer la conexión PDO
    private function __construct()
    {
        // Cargar el archivo .env
        $this->loadEnv(__DIR__ . '/../.env');

        // Obtener las variables de entorno
        $this->host = getenv('DB_HOST');
        $this->database = getenv('DB_NAME');
        $this->username = getenv('DB_USERNAME');  // Asigna el valor si usas autenticación
        $this->password = getenv('DB_PASSWORD');  // Asigna el valor si usas autenticación

        try {
            // Configura la cadena de conexión DSN
            $dsn = "sqlsrv:Server={$this->host};Database={$this->database}";

            // Crea una instancia PDO usando el DSN y las credenciales
            $this->connection = new PDO($dsn, $this->username, $this->password);

            // Configura el modo de errores para PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Muestra un mensaje de error si no se puede conectar
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    // Método para cargar el archivo .env
    private function loadEnv($file)
    {
        if (file_exists($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                putenv(trim($line));
            }
        }
    }

    // Método estático para obtener una única instancia de la conexión (Singleton)
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new SQLSRVConnector();
        }
        return self::$instance;
    }

    // Método público para obtener la conexión activa
    public function getConnection()
    {
        return $this->connection;
    }
}


