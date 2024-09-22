<?php
require_once 'SQLSRVConnector.php';
require_once '../Model/Departamento.php';

class DepartamentoODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection();
    }

    public function getAll() : array {
        $query = "SELECT ID_Departamento, Nombre FROM Departamento";
        $result = $this->connection->query($query);
        $departamentos = [];
        while ($row = $result->fetch()) {
            $departamento = new Departamento($row['ID_Departamento'], $row['Nombre']);
            array_push($departamentos, $departamento);
        }
        return $departamentos;
    }

    public function getById($id) {
        $query = "SELECT ID_Departamento, Nombre FROM Departamento WHERE ID_Departamento = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return new Departamento($row['ID_Departamento'], $row['Nombre']);
    }

    public function insert($departamento) {
        $query = "INSERT INTO Departamento (Nombre) VALUES (?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $departamento->getNombre());
        $stmt->execute();
    }

    public function update($departamento) {
        $query = "UPDATE Departamento SET Nombre = ? WHERE ID_Departamento = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $departamento->getNombre());
        $stmt->bindParam(2, $departamento->getIdDepartamento());
        $stmt->execute();
    }
}