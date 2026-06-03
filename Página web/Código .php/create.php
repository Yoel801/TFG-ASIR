<?php
session_start();
// Control de seguridad[cite: 9]
if (!isset($_SESSION['id'])) {
    header("Location: formulario_inicial.php");
    exit();
}

include("conexionBBDD.php");

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $rust_id = mysqli_real_escape_string($conexion, $_POST['rust_id']);
    $incidencia = mysqli_real_escape_string($conexion, $_POST['incidencia']);
    $prioridad = mysqli_real_escape_string($conexion, $_POST['prioridad']);
    $estado = "Pendiente"; 

    // 1. Guardamos la incidencia (SIN rustdesk_id, adaptado a tu tabla original)
    $sql_incidencias = "INSERT INTO incidencias (nombre, email, incidencia, prioridad, estado) 
                        VALUES ('$nombre', '$email', '$incidencia', '$prioridad', '$estado')";

    if (mysqli_query($conexion, $sql_incidencias)) {
        
        // 2. VinculaciÃ³n con el inventario sin duplicados
        if (!empty($rust_id)) {
            $check = mysqli_query($conexion, "SELECT nombre_pc FROM dispositivos WHERE nombre_pc = '$nombre'");
            
            if (mysqli_num_rows($check) == 0) {
                // Generamos un ID de tarjeta manual ÃšNICO basado en la hora actual del servidor
                $tarjeta_unica = 'MANUAL-' . time(); 
                
                mysqli_query($conexion, "INSERT INTO dispositivos (nombre_pc, tarjeta_id, rustdesk_id, estado) VALUES ('$nombre', '$tarjeta_unica', '$rust_id', 'Activo')");
            } else {
                // Si el PC ya existe, solo le actualizamos el ID de RustDesk
                mysqli_query($conexion, "UPDATE dispositivos SET rustdesk_id = '$rust_id' WHERE nombre_pc = '$nombre'");
            }
        }
        
        $mensaje = "<div class='alerta-exito'>âœ… Incidencia registrada correctamente. Equipo vinculado al inventario.</div>";
    } else {
        $mensaje = "<div class='alerta-error'>âŒ Error al registrar: " . mysqli_error($conexion) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Incidencia - Fixly</title>
    <link rel="stylesheet" href="../css/estilo_create.css">
</head>
<body>
    <div class="contenedor-crear">
        <h2>Nueva Incidencia</h2>
        
        <?php echo $mensaje; ?>

        <form action="create.php" method="POST">
            <div class="grupo-input">
                <label for="nombre">Nombre del Cliente / Equipo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ej: PC-AdministraciÃ³n" required>
            </div>

            <div class="grupo-input">
                <label for="email">Email de Contacto</label>
                <input type="email" id="email" name="email" placeholder="usuario@empresa.com" required>
            </div>

            <div class="grupo-input">
                <label for="rust_id">ID RustDesk del Equipo</label>
                <input type="text" id="rust_id" name="rust_id" placeholder="Ej: 123 456 789" required>
            </div>

            <div class="grupo-input">
                <label for="prioridad">Prioridad</label>
                <select id="prioridad" name="prioridad" required>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                    <option value="Critica">CrÃ­tica</option>
                </select>
            </div>

            <div class="grupo-input">
                <label for="incidencia">DescripciÃ³n de la Incidencia</label>
                <textarea id="incidencia" name="incidencia" placeholder="Describe el problema detectado..." required></textarea>
            </div>

            <button type="submit" class="btn-enviar">Registrar Incidencia</button>
        </form>

        <a href="principio.php" class="btn-cancelar">&larr; Volver al Panel Principal</a>
    </div>
</body>
</html>
