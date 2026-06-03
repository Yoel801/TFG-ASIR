<?php

$host = "192.168.216.35";
$user = "root";
$pass = "*********";
$db = "fixly";

$conex = mysqli_connect($host, $user, $pass, $db);

if (!$conex) {
    die("Error de conexion a la base de datos: " . mysqli_connect_error());
}

?>
