<?php

require_once 'SQLSRVConnector.php';
require_once '../Model/HistorialPagosPrestamos.php';

class HistorialPagosPrestamosODB
{
    private $connection;

    public function __construct()
    {
        $this->connection = SQLSRVConnector::getInstance()->getConnection(); // Obtener la conexión
        if ($this->connection === null) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todo el historial de pagos
    public function getAll(): array
    {
        $query = "EXEC MostrarHistorialDePagos";
        $result = $this->connection->query($query);
        $pagos = [];

        while ($row = $result->fetch()) {
            // Crea un nuevo objeto HistorialPagosPrestamos con los datos obtenidos
            $pago = new HistorialPagosPrestamos(
                $row['ID_Pago'],
                $row['Fecha'],
                $row['Monto'],
                $row['No_cuota'],
                $row['Saldo_Pendiente'],
                $row['ID_Poliza'],
                $row['ID_Prestamos']
            );

            // Asignar el nombre completo
            $pago->setNombreCompleto($row['NombreCompleto']);

            array_push($pagos, $pago);
        }
        return $pagos;
    }


    // Obtener historial de pagos por nombre y apellido del empleado
    public function getByNombreCompleto($NombreCompleto): array
    {
        $query = "EXEC MostrarHistorialDePagosPorNombreYApellidoEmpleado @NombreCompleto = :nombreCompleto";
    $stmt = $this->connection->prepare($query);
    $stmt->bindValue(':nombreCompleto', $NombreCompleto);
    $stmt->execute();

    $pagos = [];
    while ($row = $stmt->fetch()) {
        $pago = new HistorialPagosPrestamos(
            $row['ID_Pago'],
            $row['Fecha'],
            $row['Monto'],
            $row['No_cuota'],
            $row['Saldo_Pendiente'],
            $row['ID_Empleado'],
            $row['ID_Poliza'],
            $row['ID_Prestamos']
        );
        $pago->setNombreCompleto($row['NombreCompleto']); // Guardar el nombre completo
        array_push($pagos, $pago);
    }
    return $pagos;
    }

    // Obtener un historial de pago por ID
    public function getIDPago($id)
    {
        $query = "EXEC ObtenerHistorialDePagoPorID @ID_Pago = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch();

        return new HistorialPagosPrestamos(
            $row['ID_Pago'],
            $row['Fecha'],
            $row['Monto'],
            $row['No_cuota'],
            $row['Saldo_Pendiente'],
            $row['ID_Empleado'],
            $row['ID_Poliza'],
            $row['ID_Prestamos']
        );
    }

    // Insertar un nuevo pago y actualizar el préstamo
    public function insert($pago)
    {
        $query = "EXEC InsertarHistorialYActualizarPrestamo @Fecha = ?, @Monto = ?, @No_cuota = ?, @Saldo_Pendiente = ?, @ID_Empleado = ?, @ID_Poliza = ?, @ID_Prestamos = ?, @Cuenta_Contable = ?";
        $stmt = $this->connection->prepare($query);

        $fecha = $pago->getFecha(); // Fecha automática
        $monto = $pago->getMonto();
        $noCuota = $pago->getNoCuota();
        $saldoPendiente = $pago->getSaldoPendiente(); // Saldo Pendiente no modificable
        $idEmpleado = $pago->getIdEmpleado(); // No modificable
        $idPoliza = $pago->getIdPoliza(); // No modificable
        $idPrestamo = $pago->getIdPrestamo();
        $cuentaContable = $pago->getCuentaContable(); // Obtenido de Poliza por ID

        $stmt->bindParam(1, $fecha);
        $stmt->bindParam(2, $monto);
        $stmt->bindParam(3, $noCuota);
        $stmt->bindParam(4, $saldoPendiente);
        $stmt->bindParam(5, $idEmpleado);
        $stmt->bindParam(6, $idPoliza);
        $stmt->bindParam(7, $idPrestamo);
        $stmt->bindParam(8, $cuentaContable);

        $stmt->execute();
    }

    // Modificar un historial de pago y actualizar el préstamo
    public function update($pago)
    {
        $query = "EXEC ModificarHistorialYActualizarPrestamo @ID_Pago = ?, @Fecha = ?, @Monto = ?, @No_cuota = ?, @Saldo_Pendiente = ?, @ID_Empleado = ?, @ID_Poliza = ?, @ID_Prestamos = ?";
        $stmt = $this->connection->prepare($query);

        $idPago = $pago->getIdPago();
        $fecha = $pago->getFecha();
        $monto = $pago->getMonto();
        $noCuota = $pago->getNoCuota();
        $saldoPendiente = $pago->getSaldoPendiente();
        $idEmpleado = $pago->getIdEmpleado();
        $idPoliza = $pago->getIdPoliza();
        $idPrestamo = $pago->getIdPrestamo();

        $stmt->bindParam(1, $idPago);
        $stmt->bindParam(2, $fecha);
        $stmt->bindParam(3, $monto);
        $stmt->bindParam(4, $noCuota);
        $stmt->bindParam(5, $saldoPendiente);
        $stmt->bindParam(6, $idEmpleado);
        $stmt->bindParam(7, $idPoliza);
        $stmt->bindParam(8, $idPrestamo);

        $stmt->execute();
    }

    // Eliminar un historial de pago y actualizar el préstamo
    public function delete($idPago)
    {
        $query = "EXEC EliminarHistorialYActualizarPrestamo @ID_Pago = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $idPago);
        $stmt->execute();
    }
}

