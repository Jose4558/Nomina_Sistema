<?php

require_once 'SQLSRVConnector.php';
require_once '../Model/Expediente.php';
require_once '../Model/Empleado.php';

class ExpedienteODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection();
        if ($this->connection === null) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todos los expedientes
    public function getAll(): array {
        $query = "EXEC MostrarExpedientes";
        $result = $this->connection->query($query);

        $expedientes = [];
        while ($row = $result->fetch()) {
            $expediente = new Expediente(
                $row['ID_Expediente'],
                $row['Tipo_Documento'],
                $row['Archivo'],
                $row['ID_Empleado']
            );
            array_push($expedientes, $expediente);
        }

        return $expedientes;
    }

    // Obtener un expediente por ID
    public function getById($id) {
        $query = "EXEC BuscarExpediente @ID_Expediente = :ID_Expediente";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Expediente', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Expediente(
                    $row['ID_Expediente'],
                    $row['Tipo_Documento'],
                    $row['Archivo'],
                    $row['ID_Empleado']
                );
            }
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
            return null;
        }

        return null;
    }

    // Modificar un expediente
    public function update($idExpediente, $tipoDocumento, $archivo, $idEmpleado) {
        try {
            if ($archivo) {
                // Consulta cuando se sube un archivo
                $query = "EXEC ModificarExpediente 
                        @ID_Expediente = :ID_Expediente, 
                        @Tipo_Documento = :Tipo_Documento, 
                        @Archivo = :Archivo, 
                        @ID_Empleado = :ID_Empleado";
            } else {
                // Consulta cuando no se sube un archivo
                $query = "EXEC ModificarExpediente 
                        @ID_Expediente = :ID_Expediente, 
                        @Tipo_Documento = :Tipo_Documento, 
                        @Archivo = NULL, 
                        @ID_Empleado = :ID_Empleado";
            }

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Expediente', $idExpediente, PDO::PARAM_INT);
            $stmt->bindParam(':Tipo_Documento', $tipoDocumento);
            $stmt->bindParam(':ID_Empleado', $idEmpleado, PDO::PARAM_INT);

            if ($archivo) {
                $stmt->bindParam(':Archivo', $archivo, PDO::PARAM_LOB);
            }

            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            error_log("Failed to execute update: " . $e->getMessage());
            return false;
        }
    }

    // Insertar un nuevo expediente
    // Insertar un nuevo expediente
    public function insert($expediente) {
        try {
            $tipoDocumento = $expediente->getTipoDocumento();
            $archivo = $expediente->getArchivo();
            $idEmpleado = $expediente->getIdEmpleado();

            // Verifica si se sube un archivo
            if ($archivo) {
                // Consulta cuando se sube un archivo
                $query = "EXEC InsertarExpediente 
                      @Tipo_Documento = :Tipo_Documento, 
                      @Archivo = :Archivo, 
                      @ID_Empleado = :ID_Empleado";
            } else {
                // Consulta cuando no se sube un archivo
                $query = "EXEC InsertarExpediente 
                      @Tipo_Documento = :Tipo_Documento, 
                      @Archivo = NULL, 
                      @ID_Empleado = :ID_Empleado";
            }

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':Tipo_Documento', $tipoDocumento);
            $stmt->bindParam(':ID_Empleado', $idEmpleado, PDO::PARAM_INT);

            if ($archivo) {
                $stmt->bindParam(':Archivo', $archivo, PDO::PARAM_LOB);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Excepción capturada al insertar expediente: " . $e->getMessage());
            return false;
        }
    }


    // Eliminar un expediente
    public function delete($id) {
        $query = "EXEC BorrarExpediente @ID_Expediente = :ID_Expediente";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ID_Expediente', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}
