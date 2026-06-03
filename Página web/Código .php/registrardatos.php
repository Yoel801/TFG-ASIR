<?php
session_start(); // Fundamental para mantener al usuario dentro
include ("conexionBBDD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    // 1. Buscar al usuario por nombre
    $sql = "SELECT id, password FROM usuarios WHERE nombre = '$nombre'";
    $resultado = mysqli_query($conexion, $sql);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // 2. Verificar la contraseña encriptada
        if (password_verify($password, $usuario['password'])) {
            // ¡ÉXITO! Creamos la sesión
            $_SESSION['id'] = $usuario['id'];
            // 3. Redirigir a la web principal
            header("Location: principio.php"); 
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El nombre de usuario no está registrado.";
    }
}
?>
