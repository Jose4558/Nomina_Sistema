<?php
require_once 'SQLSRVConnector.php';
require_once '../Model/Produccion.php';

class ProduccionODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection(); // Obtén la conexión aquí
        if ($this->connection === null) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function mostrarProduccion() : array {
        $query = "EXEC MostrarProduccionPorEmpleado";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $producciones = [];
        foreach ($result as $row) {
            $produccion = new Produccion(
                $row['ID_Produccion'],
                $row['Fecha'],
                $row['Piezas_Elaboradas'],
                $row['Bonificacion'],
                $row['ID_Empleado'],
                $row['ID_Poliza']
            );
            array_push($producciones, $produccion);
        }
        return $producciones;
    }

    public function buscarProduccionPorId($idProduccion) {
        $query = "EXEC BuscarProduccionPorEmpleado ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $idProduccion);
        $stmt->execute();
        $row = $stmt->fetch();
        return new Produccion(
            $row['ID_Produccion'],
            $row['Fecha'],
            $row['Piezas_Elaboradas'],
            $row['Bonificacion'],
            $row['ID_Empleado'],
            $row['ID_Poliza']
        );
    }

    public function modificarProduccion($idProduccion, $piezasElaboradas, $bonificacion, $idEmpleado, $descripcion, $cuentaContable) {
        $query = "EXEC ModificarProduccion ?, ?, ?, ?, ?, ?";
        $stmt = $this->connection->prepare($query);
        // Asignar los parámetros a la consulta
        $stmt->bindParam(1, $idProduccion);          // ID de Producción
        $stmt->bindParam(2, $piezasElaboradas);      // Piezas Elaboradas
        $stmt->bindParam(3, $bonificacion);          // Bonificación calculada
        $stmt->bindParam(4, $idEmpleado);            // ID de Empleado
        $stmt->bindParam(5, $descripcion);           // Descripción
        $stmt->bindParam(6, $cuentaContable);        // Cuenta Contable

        // Ejecutar la consulta
        $stmt->execute();
    }


    public function insertarProduccionYPoliza($piezasElaboradas, $bonificacion, $idEmpleado, $descripcion, $cuentaContable) {
        $query = "EXEC InsertarProduccionYPoliza ?, ?, ?, ?, ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $piezasElaboradas);
        $stmt->bindParam(2, $bonificacion);
        $stmt->bindParam(3, $idEmpleado);
        $stmt->bindParam(4, $descripcion);
        $stmt->bindParam(5, $cuentaContable);
        $stmt->execute();
    }

    public function borrarProduccion($idProduccion) {
        $query = "EXEC BorrarProduccion ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $idProduccion);
        $stmt->execute();
    }
}
?>
