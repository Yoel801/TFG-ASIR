<?php

include("conexionBBDD.php");

if ($conex) {
    echo "<h1>La conexión es exitosa</h1>";
    echo "Informacion del host" . mysqli_get_host_info($conex);
} else {
    echo "<h1>La conexión ha fallado</h1>";
    echo "Detalle: " . mysqli_connection_error();
}
?>
