<?php

echo realpath('../Controller/C_verEmpleado.php'); // Esto te dará la ruta absoluta que PHP está tratando de abrir
require '../Controller/C_verEmpleado.php';

echo realpath('../Controller/C_ModEmpleado.php'); // Esto te dará la ruta absoluta que PHP está tratando de abrir
require '../Controller/C_ModEmpleado.php';

echo realpath('../Controller/C_CrearEmpleado.php'); // Esto te dará la ruta absoluta que PHP está tratando de abrir
require '../Controller/C_CrearEmpleado.php';

echo realpath('../Controller/C_BuscarAusencia.php'); // Esto te dará la ruta absoluta que PHP está tratando de abrir
require '../Controller/C_BuscarAusencia.php';

echo realpath('../Controller/C_AusenciaAutorizacion.php'); // Esto te dará la ruta absoluta que PHP está tratando de abrir
require '../Controller/C_AusenciaAutorizacion.php';

?>