<?php

class Conexion
{
    private $con;

    public function __construct() {
        try {
            $this->con = new PDO('sqlsrv:server=DESKTOP-D5H41I4;database=TConsulting', null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::SQLSRV_ATTR_DIRECT_QUERY => true,
                PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE => true,
                PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
            ]);
        } catch (PDOException $e) {
            error_log("Connection error: " . $e->getMessage());
            // Handle exception
        }
    }

    public function getUser() {
        try {
            $stmt = $this->con->prepare("EXEC Ver_Empleado");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            return [];
        }
    }

    public function modificarEmpleado($ID_Empleado, $Nombre, $Apellido, $Fecha_Nac, $Fecha_Contra, $Salario_Base, $Depto_ID, $Foto) {
        try {
            // Asegurarse de que los datos están en UTF-8
            $Nombre = mb_convert_encoding($Nombre, 'UTF-8');
            $Apellido = mb_convert_encoding($Apellido, 'UTF-8');

            if ($Foto === NULL) {
                // No modificar la columna Foto
                $query = "UPDATE Empleado SET Nombre = :Nombre, Apellido = :Apellido, Fecha_Nac = :Fecha_Nac, Fecha_Contra = :Fecha_Contra, Salario_Base = :Salario_Base, Depto_ID = :Depto_ID WHERE ID_Empleado = :ID_Empleado";
                $stmt = $this->con->prepare($query);
                $stmt->bindParam(':Nombre', $Nombre);
                $stmt->bindParam(':Apellido', $Apellido);
                $stmt->bindParam(':Fecha_Nac', $Fecha_Nac);
                $stmt->bindParam(':Fecha_Contra', $Fecha_Contra);
                $stmt->bindParam(':Salario_Base', $Salario_Base);
                $stmt->bindParam(':Depto_ID', $Depto_ID);
                $stmt->bindParam(':ID_Empleado', $ID_Empleado);
            } else {
                // Modificar la columna Foto también
                $query = "UPDATE Empleado SET Nombre = :Nombre, Apellido = :Apellido, Fecha_Nac = :Fecha_Nac, Fecha_Contra = :Fecha_Contra, Salario_Base = :Salario_Base, Depto_ID = :Depto_ID, Foto = :Foto WHERE ID_Empleado = :ID_Empleado";
                $stmt = $this->con->prepare($query);
                $stmt->bindParam(':Nombre', $Nombre);
                $stmt->bindParam(':Apellido', $Apellido);
                $stmt->bindParam(':Fecha_Nac', $Fecha_Nac);
                $stmt->bindParam(':Fecha_Contra', $Fecha_Contra);
                $stmt->bindParam(':Salario_Base', $Salario_Base);
                $stmt->bindParam(':Depto_ID', $Depto_ID);
                $stmt->bindParam(':Foto', $Foto, PDO::PARAM_LOB); // Parámetro tipo LOB para datos binarios
                $stmt->bindParam(':ID_Empleado', $ID_Empleado);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                // Mostrar el error si la ejecución falla
                echo "Error en la consulta: " . implode(" ", $stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            // Capturar cualquier excepción y mostrar el mensaje
            echo "Excepción capturada: " . $e->getMessage();
            return false;
        }
    }
}

?>
