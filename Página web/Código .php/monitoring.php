<?php
session_start();
// Control de acceso: solo usuarios logueados[cite: 9]
if (!isset($_SESSION['id'])) {
    header("Location: formulario_inicial.php");
    exit();
}

// ConexiÃ³n a la base de datos[cite: 2]
include("conexionBBDD.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Finalizados - Fixly</title>
    <link rel="stylesheet" href="../css/estilo_monitoring.css">
</head>
<body>

    <div class="contenedor-historial">
        <div class="cabecera-seccion">
            <h1> Historial de Incidencias</h1>
            <a href="principio.php" class="btn-volver">â† Volver al Panel</a>
        </div>

        <?php
        // Consultamos las incidencias que están en estado 'Resuelta' o 'Anulada'[cite: 8]
        $sql = "SELECT id, nombre, incidencia, fecha, estado 
                FROM incidencias 
                WHERE estado IN ('Resuelta', 'Anulada') 
                ORDER BY fecha DESC";
        
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
        ?>
            <table class="tabla-finalizados">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>DescripciÃ³n</th>
                        <th>Fecha de Registro</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_array()) { 
                        $esAnulada = ($row['estado'] == 'Anulada');
                    ?>
                        <tr class="<?php echo $esAnulada ? 'fila-anulada' : ''; ?>">
                            <td><b>#<?php echo $row['id']; ?></b></td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['incidencia']); ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td>
                                <span class="badge <?php echo $esAnulada ? 'badge-anulada' : 'badge-resuelta'; ?>">
                                    <?php echo $row['estado']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<div class='mensaje-vacio'>No hay registros de incidencias resueltas o anuladas.</div>";
        }
        ?>

        <footer>
            <p>&copy; 2026 Fixly - Yoel Vicente Caro / Carlos Alonso Seral[cite: 5]</p>
            <p style="margin-top: 5px;">Versión 1.3.0</p>
        </footer>
    </div>

</body>
</html>
