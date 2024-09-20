<?php
require '../Model/Conexion.php';

$con = new Conexion();

$familiares = $con-> ListarFamiliares();

require '../Views/V_VerFamiliar.php';

?>
