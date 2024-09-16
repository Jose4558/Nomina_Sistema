<?php

require '../Model/Conexion.php';

$con = new Conexion();

$Empleados = $con-> getUser();

require 'C:/xampp/htdocs/Nomina_Sistemas/Views/V_verEmpleado.php';

?>