<?php
require_once 'SQLSRVConnector.php';
require_once '../Model/Ausencia.php';

class AusenciaODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection(); // Obtén la conexión aquí
        if ($this->connection === null) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function getAll() : array {
        $query = "SELECT * FROM Ausencias"; // Asegúrate de que la consulta sea la correcta
        $result = $this->connection->query($query);
        $ausencias = [];
        while ($row = $result->fetch()) {
            $ausencia = new Ausencia(
                $row['ID_Solicitud'],
                $row['Fecha_Inicio'],
                $row['Fecha_Fin'],
                $row['Motivo'],
                $row['Estado'],
                $row['Cuenta_Salario'],
                $row['Descuento'],
                $row['ID_Empleado']
            );
            array_push($ausencias, $ausencia);
        }
        return $ausencias;
    }

    public function getById($id) {
        $query = "EXEC BuscarAusencia @ID_Solicitud = :ID_Solicitud";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Solicitud', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Ausencia(
                    $row['ID_Solicitud'],
                    $row['Fecha_Inicio'],
                    $row['Fecha_Fin'],
                    $row['Motivo'],
                    $row['Estado'],
                    $row['Cuenta_Salario'],
                    $row['Descuento'],
                    $row['ID_Empleado']
                );
            }
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
            return null;
        }

        return null;
    }

    public function insert($ausencia) {
        $query = "EXEC InsertarAusencia @Fecha_Inicio = :Fecha_Inicio, @Fecha_Fin = :Fecha_Fin, @Motivo = :Motivo, @Estado = :Estado, @Cuenta_Salario = :Cuenta_Salario, @Descuento = :Descuento, @ID_Empleado = :ID_Empleado";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':Fecha_Inicio', $ausencia->getFechaInicio());
            $stmt->bindParam(':Fecha_Fin', $ausencia->getFechaFin());
            $stmt->bindParam(':Motivo', $ausencia->getMotivo());
            $stmt->bindParam(':Estado', $ausencia->getEstado());
            $stmt->bindParam(':Cuenta_Salario', $ausencia->getCuentaSalario());
            $stmt->bindParam(':Descuento', $ausencia->getDescuento());
            $stmt->bindParam(':ID_Empleado', $ausencia->getIdEmpleado());
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
        }
    }

    public function update($ausencia) {
        $query = "EXEC ModificarAusencia @ID_Solicitud = :ID_Solicitud, @Motivo = :Motivo, @Fecha_Inicio = :Fecha_Inicio, @Fecha_Fin = :Fecha_Fin, @Estado = :Estado";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Solicitud', $ausencia->getIdSolicitud(), PDO::PARAM_INT);
            $stmt->bindParam(':Motivo', $ausencia->getMotivo(), PDO::PARAM_STR);
            $stmt->bindParam(':Fecha_Inicio', $ausencia->getFechaInicio(), PDO::PARAM_STR);
            $stmt->bindParam(':Fecha_Fin', $ausencia->getFechaFin(), PDO::PARAM_STR);
            $stmt->bindParam(':Estado', $ausencia->getEstado(), PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $query = "EXEC BorrarAusencia @ID_Solicitud = :ID_Solicitud";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Solicitud', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
        }
    }
}
