<?php

require_once 'SQLSRVConnector.php';
require_once '../Model/Poliza.php';

class PolizaODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection();
        if ($this->connection === null) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function getAll(): array {
        $query = "EXEC MostrarPoliza"; // Llamar al procedimiento para mostrar todas las pólizas
        $result = $this->connection->query($query);

        $polizas = [];
        while ($row = $result->fetch()) {
            $poliza = new Poliza(
                $row['ID_Poliza'],
                $row['Fecha'],
                $row['Descripción'],
                $row['Monto'],
            );
            array_push($polizas, $poliza);
        }

        return $polizas;
    }

    public function getById($idPoliza) {
        $query = "EXEC BuscarPolizaPorID @ID_Poliza = :ID_Poliza";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Poliza', $idPoliza, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Poliza(
                    $row['ID_Poliza'],
                    $row['Fecha'],
                    $row['Descripción'],
                    $row['Monto'],
                    $row['Cuenta_Contable']
                );
            }
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
            return null;
        }

        return null;
    }

    public function update($idPoliza, $fecha, $descripcion, $monto, $cuentaContable) {
        $query = "EXEC ModificarPoliza 
              @ID_Poliza = :ID_Poliza, 
              @Fecha = :Fecha, 
              @Descripción = :Descripción, 
              @Monto = :Monto, 
              @Cuenta_Contable = :Cuenta_Contable";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Poliza', $idPoliza, PDO::PARAM_INT);
            $stmt->bindParam(':Fecha', $fecha);
            $stmt->bindParam(':Descripción', $descripcion);
            $stmt->bindParam(':Monto', $monto);
            $stmt->bindParam(':Cuenta_Contable', $cuentaContable);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed to execute update: " . $e->getMessage());
            return false;
        }
    }

    public function insert($poliza) {
        try {
            // Extraer los atributos del objeto poliza
            $fecha = $poliza->getFecha();
            $descripcion = $poliza->getDescripcion();
            $monto = $poliza->getMonto();
            $cuentaContable = $poliza->getCuentaContable();

            // Definir la consulta SQL usando parámetros posicionales
            $query = "EXEC InsertarPoliza @Fecha = ?, 
                                          @Descripción = ?, 
                                          @Monto = ?, 
                                          @Cuenta_Contable = ?";

            // Preparar la declaración SQL
            $stmt = $this->connection->prepare($query);

            // Vincular los parámetros
            $stmt->bindParam(1, $fecha);
            $stmt->bindParam(2, $descripcion);
            $stmt->bindParam(3, $monto);
            $stmt->bindParam(4, $cuentaContable);

            // Ejecutar la declaración y devolver el resultado
            return $stmt->execute();
        } catch (PDOException $e) {
            // Registrar el mensaje de error
            error_log("Failed to execute insert: " . $e->getMessage());
            return false;
        }
    }

    public function delete($idPoliza) {
        try {
            $stmt = $this->connection->prepare("EXEC BorrarPolizaPorID @ID_Poliza = :ID_Poliza");
            $stmt->bindParam(':ID_Poliza', $idPoliza, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Failed to execute delete: " . $e->getMessage());
            return false;
        }
    }
}

?>
