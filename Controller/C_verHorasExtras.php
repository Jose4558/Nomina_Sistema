<?php

require '../Model/Conexion.php';

$con = new Conexion();

$horasExtras = $con->mostrarHorasExtras();

require '../Views/V_verHorasExtras.php';

