<?php

require '../Model/Conexion.php';

$con = new Conexion();

$expedientes = $con->mostrarExpedientes();

require '../Views/V_verExpediente.php';

?>
