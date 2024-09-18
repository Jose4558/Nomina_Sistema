<?php

require '../Model/Conexion.php';

$con = new Conexion();

$Empleados = $con-> getUser();

require '../Views/V_verEmpleado.php';

?>