<?php

require_once 'SQLSRVConnector.php';
require_once '../Model/Empleado.php';
require_once '../Model/Departamento.php';

class EmpleadoODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection();
        if ($this->connection === null) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function getAll() : array {
        $query = "EXEC MostrarEmpleados";
        $result = $this->connection->query($query);

        $empleados = [];
        while ($row = $result->fetch()) {
            $empleado = new Empleado(
                $row['ID_Empleado'],
                $row['Nombre'],
                $row['Apellido'],
                $row['Fecha_Nacimiento'],
                $row['Fecha_Contratacion'],
                $row['Salario_Base'],
                new Departamento($row['ID_Departamento'], $row['Departamento']),
                $row['Foto'],
                1 // Activo siempre será 1 en este caso, porque ya se filtraron los inactivos
            );
            array_push($empleados, $empleado);
        }

        return $empleados;
    }

    public function getById($id) {
        $query = "EXEC BuscarEmpleado @ID_Empleado = :ID_Empleado";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':ID_Empleado', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $departamento = new Departamento($row['ID_Departamento'], $row['Departamento']);

                return new Empleado(
                    $row['ID_Empleado'],
                    $row['Nombre'],
                    $row['Apellido'],
                    $row['Fecha_Nacimiento'],
                    $row['Fecha_Contratacion'],
                    $row['Salario_Base'],
                    $departamento,
                    $row['Foto'],
                    $row['Activo']
                );
            }
        } catch (PDOException $e) {
            error_log("Failed to execute query: " . $e->getMessage());
            return null;
        }

        return null;
    }

    public function insertarEmpleado($Nombre, $Apellido, $Fecha_Nac, $Fecha_Contra, $Salario_Base, $Depto_ID, $Foto)
    {
        try {
            $Nombre = mb_convert_encoding($Nombre, 'UTF-8');
            $Apellido = mb_convert_encoding($Apellido, 'UTF-8');

            if ($Foto === NULL) {
                $query = "INSERT INTO Empleado (Nombre, Apellido, Fecha_Nac, Fecha_Contra, Salario_Base, Depto_ID)
                          VALUES (:Nombre, :Apellido, :Fecha_Nac, :Fecha_Contra, :Salario_Base, :Depto_ID)";
            } else {
                $query = "INSERT INTO Empleado (Nombre, Apellido, Fecha_Nac, Fecha_Contra, Salario_Base, Depto_ID, Foto)
                          VALUES (:Nombre, :Apellido, :Fecha_Nac, :Fecha_Contra, :Salario_Base, :Depto_ID, CONVERT(varbinary(max), :Foto))";
            }

            $stmt = $this->connection->prepare($query);

            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Apellido', $Apellido);
            $stmt->bindParam(':Fecha_Nac', $Fecha_Nac);
            $stmt->bindParam(':Fecha_Contra', $Fecha_Contra);
            $stmt->bindParam(':Salario_Base', $Salario_Base);
            $stmt->bindParam(':Depto_ID', $Depto_ID);

            if ($Foto !== NULL) {
                $stmt->bindParam(':Foto', $Foto, PDO::PARAM_LOB);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error en la consulta: " . implode(" ", $stmt->errorInfo()));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Excepción capturada: " . $e->getMessage());
            return false;
        }
    }

    public function insert($empleado) {
        try {
            $query = "EXEC InsertarEmpleado ?, ?, ?, ?, ?, ?, CONVERT(varbinary(max), ?), ?";
            $stmt = $this->connection->prepare($query);
            $activo = 1;

            $nombre = $empleado->getNombre();
            $apellido = $empleado->getApellido();
            $fechaNacimiento = $empleado->getFechaNacimiento();
            $fechaContratacion = $empleado->getFechaContratacion();
            $salarioBase = $empleado->getSalarioBase();
            $deptoID = $empleado->getDepartamento()->getIdDepartamento();
            $foto = $empleado->getFoto() !== null ? $empleado->getFoto() : null;

            error_log("Nombre: $nombre, Apellido: $apellido, Fecha Nac: $fechaNacimiento");

            $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $apellido, PDO::PARAM_STR);
            $stmt->bindParam(3, $fechaNacimiento, PDO::PARAM_STR);
            $stmt->bindParam(4, $fechaContratacion, PDO::PARAM_STR);
            $stmt->bindParam(5, $salarioBase, PDO::PARAM_STR);
            $stmt->bindParam(6, $deptoID, PDO::PARAM_INT);
            $stmt->bindParam(7, $foto, PDO::PARAM_LOB);
            $stmt->bindParam(8, $activo, PDO::PARAM_BOOL);

            if ($stmt->execute()) {
                error_log("Empleado insertado con éxito.");
                return true;
            } else {
                error_log("Error en la ejecución: " . implode(" ", $stmt->errorInfo()));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Excepción capturada: " . $e->getMessage());
            return false;
        }
    }


    public function update($empleado) {
        try {
            $query = "EXEC ModificarEmpleado ?, ?, ?, ?, ?, ?, ?, CONVERT(varbinary(max), ?), ?";
            $stmt = $this->connection->prepare($query);
            $activo = 1;

            $nombre = $empleado->getNombre();
            $apellido = $empleado->getApellido();
            $fechaNac = $empleado->getFechaNacimiento();
            $fechaContra = $empleado->getFechaContratacion();
            $salarioBase = $empleado->getSalarioBase();
            $deptoID = $empleado->getDepartamento()->getIdDepartamento();
            $foto = $empleado->getFoto();
            $idEmpleado = $empleado->getIdEmpleado();

            $stmt->bindParam(1, $idEmpleado, PDO::PARAM_INT);
            $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
            $stmt->bindParam(3, $apellido, PDO::PARAM_STR);
            $stmt->bindParam(4, $fechaNac, PDO::PARAM_STR);
            $stmt->bindParam(5, $fechaContra, PDO::PARAM_STR);
            $stmt->bindParam(6, $salarioBase, PDO::PARAM_STR);
            $stmt->bindParam(7, $deptoID, PDO::PARAM_INT);
            $stmt->bindParam(8, $foto, PDO::PARAM_LOB);

            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed to update employee: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $query = "EXEC DesactivarEmpleado @ID_Empleado = :ID_Empleado";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ID_Empleado', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}