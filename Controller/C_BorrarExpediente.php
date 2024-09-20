<?php


require '../Model/Conexion.php'; // Incluye el archivo donde está la clase de conexión a la base de datos

$conexion = new Conexion();

// Verificar si se ha recibido el ID del expediente a eliminar
if (isset($_POST['No_Expedientes'])) {
    $No_Expedientes = intval($_POST['No_Expedientes']); // Asegurarse de que sea un valor entero

    try {
        // Preparar la consulta llamando al procedimiento almacenado
        $stmt = $conexion->prepare("
            EXEC BorrarExpediente 
            @No_Expedientes = :No_Expedientes
        ");

        // Vincular el parámetro
        $stmt->bindParam(':No_Expedientes', $No_Expedientes, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Expediente eliminado exitosamente.";
        } else {
            echo "Error al eliminar el expediente.";
        }
    } catch (PDOException $e) {
        // Captura y muestra el error en caso de que ocurra
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: No se ha proporcionado un número de expediente válido.";
}

