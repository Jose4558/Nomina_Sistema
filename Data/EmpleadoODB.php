<?php

require_once 'SQLSRVConnector.php';
require_once '../Model/Empleado.php';
require_once '../Model/Departamento.php';

class EmpleadoODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection();
    }

    public function getAll() : array {
        $query = "SELECT
                    E.ID_Empleado, E.Nombre, E.Apellido, E.Fecha_Nacimiento, E.Fecha_Contratacion, ROUND(CAST(E.Salario_Base AS DECIMAL(18,2)), 2) AS Salario_Base, 
                    D.ID_Departamento, E.Foto, D.Nombre AS Departamento
                FROM Empleado E 
                INNER JOIN Departamento D ON E.FK_ID_Departamento = D.ID_Departamento";
        $result = $this->connection->query($query);
        $empleados = [];
        while ($row = $result->fetch()) {
            $empleado = new Empleado($row['ID_Empleado'], $row['Nombre'], $row['Apellido'], $row['Fecha_Nacimiento'], $row['Fecha_Contratacion'], $row['Salario_Base'], 
            new Departamento($row['ID_Departamento'], $row['Departamento']), $row['Foto']);
            array_push($empleados, $empleado);
        }
        return $empleados;
    }

    public function getById($id) {
        $query = "
            SELECT
                E.ID_Empleado, E.Nombre, E.Apellido, E.Fecha_Nacimiento, E.Fecha_Contratacion, ROUND(CAST(E.Salario_Base AS DECIMAL(18,2)), 2) AS Salario_Base, 
                D.ID_Departamento, E.Foto, D.Nombre AS Departamento
            FROM Empleado E 
            INNER JOIN Departamento D ON E.FK_ID_Departamento = D.ID_Departamento
            WHERE E.ID_Empleado = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return new Empleado($row['ID_Empleado'], $row['Nombre'], $row['Apellido'], $row['Fecha_Nacimiento'], $row['Fecha_Contratacion'], $row['Salario_Base'], 
        new Departamento($row['ID_Departamento'], $row['Departamento']), $row['Foto']);
    }

    public function insert($empleado) {
        $query = "INSERT INTO Empleado (Nombre, Apellido, Fecha_Nacimiento, Fecha_Contratacion, Salario_Base, FK_ID_Departamento, Foto) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $empleado->getNombre());
        $stmt->bindParam(2, $empleado->getApellido());
        $stmt->bindParam(3, $empleado->getFechaNacimiento());
        $stmt->bindParam(4, $empleado->getFechaContratacion());
        $stmt->bindParam(5, $empleado->getSalarioBase());
        $stmt->bindParam(6, $empleado->getDepartamento()->getIdDepartamento());
        $stmt->bindParam(7, $empleado->getFoto());
        $stmt->execute();
    }

    public function update($empleado) {
        $query = "UPDATE Empleado 
                SET Nombre = ?, Apellido = ?, Fecha_Nacimiento = ?, Fecha_Contratacion = ?, Salario_Base = ?, FK_ID_Departamento = ?, Foto = ?
                WHERE ID_Empleado = ?";
        $stmt = $this->connection->prepare($query);
        
        $nombre = $empleado->getNombre();
        $apellido = $empleado->getApellido();
        $fechaNac = $empleado->getFechaNacimiento();
        $fechaContra = $empleado->getFechaContratacion();
        $salarioBase = $empleado->getSalarioBase();
        $deptoID = $empleado->getDepartamento()->getIdDepartamento();
        $foto = $empleado->getFoto();
        $idEmpleado = $empleado->getIdEmpleado();
        
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $apellido);
        $stmt->bindParam(3, $fechaNac);
        $stmt->bindParam(4, $fechaContra);
        $stmt->bindParam(5, $salarioBase);
        $stmt->bindParam(6, $deptoID);
        $stmt->bindParam(7, $foto);
        $stmt->bindParam(8, $idEmpleado);
        
        $stmt->execute();
    }
    

    public function delete($id) {
        $query = "DELETE FROM Empleado WHERE ID_Empleado = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }
    
}