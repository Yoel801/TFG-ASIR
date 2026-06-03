<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: formulario_inicial.php");
        exit();
    }
    // ConexiÃ³n a la base de datos
    include("conexionBBDD.php");
    //Obtener el ID del usuario logueado
    $id = $_SESSION['id'];
    //Pedimos solamente el nombnre del usuario logueado
    $sql = "SELECT nombre, fecha_registro FROM usuarios WHERE id = $id";
    $stmt = mysqli_query($conexion, $sql);
    //Guardamops el resultado en una variable
    $datos = mysqli_fetch_assoc($stmt);
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Fixly</title>
    <link rel="stylesheet" href="../css/web_principio_usuario.css">
</head>
<body>
<div class="perfil">
    <h2>Bienvenido a tu perfil <?php echo $datos['nombre']; ?>!</h2>
<div class="dato">
    <strong>Usuario:</strong> <?php echo $datos['nombre']; ?>
</div>
<div class="dato">
    <strong>Fecha de registro:</strong> <?php echo $datos['fecha_registro']; ?>
</div>
    <nav>
        <ul class = "menu-horizontal">
            <li><a href="incidencias.php">Incidencias</a></li>
            <li><a href="create.php">Crear Incidencia</a></li>
            <li><a href="edit.php">Editar Incidencia</a></li>
            <li><a href="monitoring.php">Monitoreo</a></li>
        </ul>
    </nav>
    <a href="logout.php"><button class="logout-button">Cerrar sesión</button></a>
</body>
</html>
