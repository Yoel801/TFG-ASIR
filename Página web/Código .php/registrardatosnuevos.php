<?php
// 1. Conexión a la base de datos
session_start();
include ("conexionBBDD.php");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
// 2. Comprobar que llegan datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_tarjeta = $_POST['id_tarjeta'];
    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    // 3. LA CLAVE: Usar INSERT para guardar, no SELECT
    $sql = "INSERT INTO usuarios (nombre, email, password, id_tarjeta) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $password_hash, $id_tarjeta);
    if (mysqli_stmt_execute($stmt)) {
        $usuario_id_creado = mysqli_insert_id($conexion);
        $sql_tarjeta = "INSERT INTO tarjetas (usuario_id, id_tarjeta, nombre_usuario, email) VALUES (?, ?, ?, ?)";
        $stmt_tarjeta = mysqli_prepare($conexion, $sql_tarjeta);
        mysqli_stmt_bind_param($stmt_tarjeta, "isss", $usuario_id_creado, $id_tarjeta, $nombre, $email);
        if (mysqli_stmt_execute($stmt_tarjeta)) {
            echo "<h2>Registro completado con éxito!</h2>";
            echo "<a href='formulario_inicial.php'>Ir al inicio para loguearme</a>";
        } else {
            echo "Error al registrar tarjeta: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt_tarjeta);
    } else {
        // Si sale error aquí, puede que el email ya exista
        echo "Error al registrar: " . mysqli_error($conexion);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conexion);
?>
