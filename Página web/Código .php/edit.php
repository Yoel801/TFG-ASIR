<?php
session_start();
if (!isset($_SESSION['id'])) { header("Location: formulario_inicial.php"); exit(); }
include("conexionBBDD.php");

$mensaje = "";
$incidencia_editar = null;

// 1. Buscar incidencia para editar
if (isset($_GET['buscar_id'])) {
    $id_buscar = intval($_GET['buscar_id']);
    $res = mysqli_query($conexion, "SELECT * FROM incidencias WHERE id = $id_buscar");
    $incidencia_editar = mysqli_fetch_assoc($res);
    if (!$incidencia_editar) $mensaje = "<div class='alerta-error'>Incidencia no encontrada.</div>";
}

// 2. Procesar Actualización o Anulación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $desc = mysqli_real_escape_string($conexion, $_POST['incidencia']);
    $prioridad = $_POST['prioridad'];
    
    if (isset($_POST['anular'])) {
        $sql = "UPDATE incidencias SET estado = 'Anulada' WHERE id = $id";
        $mensaje_texto = "Incidencia anulada correctamente.";
    } else {
        $sql = "UPDATE incidencias SET nombre='$nombre', incidencia='$desc', prioridad='$prioridad' WHERE id = $id";
        $mensaje_texto = "Incidencia actualizada correctamente.";
    }

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "<div class='alerta-exito'>âœ… $mensaje_texto</div>";
        $incidencia_editar = null; // Limpiar formulario
    } else {
        $mensaje = "<div class='alerta-error'>âŒ Error: " . mysqli_error($conexion) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Incidencia - Fixly</title>
    <link rel="stylesheet" href="../css/estilo_edit.css">
</head>
<body>
    <div class="card">
        <h2>GestiÃ³n de Errores</h2><br>
        <?php echo $mensaje; ?>
        
        <form method="GET">
            <label>Introduce ID para buscar:</label>
            <div style="display: flex; gap: 5px;">
                <input type="number" name="buscar_id" required>
                <button type="submit" style="padding: 0.8rem; border-radius: 12px; cursor: pointer;">ðŸ”</button>
            </div>
        </form>

        <?php if ($incidencia_editar): ?>
            <hr><br>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $incidencia_editar['id']; ?>">
                <label>Nombre Cliente:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($incidencia_editar['nombre']); ?>" required>
                <label>DescripciÃ³n:</label>
                <textarea name="incidencia" required><?php echo htmlspecialchars($incidencia_editar['incidencia']); ?></textarea>
                <label>Prioridad:</label>
                <select name="prioridad">
                    <option value="Media" <?php if($incidencia_editar['prioridad']=='Media') echo 'selected'; ?>>Media</option>
                    <option value="Alta" <?php if($incidencia_editar['prioridad']=='Alta') echo 'selected'; ?>>Alta</option>
                    <option value="Critica" <?php if($incidencia_editar['prioridad']=='Critica') echo 'selected'; ?>>Crítica</option>
                </select>
                <button type="submit" name="actualizar" class="btn-update">Guardar Cambios</button>
                <button type="submit" name="anular" class="btn-anular" onclick="return confirm('Â¿Seguro que quieres anular esta incidencia?')">Anular Incidencia</button>
            </form>
        <?php endif; ?>
        <br><a href="principio.php" style="text-decoration: none; color: #64748b; display: block; text-align: center;">â† Volver</a>
    </div>
</body>
</html>
