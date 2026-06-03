<?php
session_start();
// Control de acceso[cite: 9]
if (!isset($_SESSION['id'])) {
    header("Location: formulario_inicial.php");
    exit();
}

include("conexionBBDD.php");

// Procesar el cambio de estado (Semáforo)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_incidencia'])) {
    $id_upd = intval($_POST['id_incidencia']);
    $est_upd = trim($_POST['nuevo_estado']);
    mysqli_query($conexion, "UPDATE incidencias SET estado = '$est_upd' WHERE id = $id_upd");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Incidencias - Fixly</title>
    <link rel="stylesheet" href="../css/estilo_incidencias.css">
</head>
<body>

    <div class="barra-superior">
        <a href="principio.php" class="btn-volver-top">&larr; Volver al Panel</a>
        <div class="contenedor-buscador">
            <span class="icono-lupa">ðŸ”</span>
            <input type="text" id="buscador" class="input-buscador" placeholder="Buscar incidencia..." onkeyup="filtrar()">
        </div>
    </div>

    <h1>Incidencias Activas</h1>
    
    <div class="grid">
        <?php
        $res = mysqli_query($conexion, "SELECT * FROM incidencias WHERE estado NOT IN ('Resuelta', 'Anulada') ORDER BY id DESC");
        
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $clase = str_replace(' ', '-', $row['estado']);
                
                $rd_id = null;

                // 1. COMPROBACIÓN HÍBRIDA: Primero vemos si la incidencia se creÃ³ a mano y ya tiene el ID
                if (isset($row['rustdesk_id']) && !empty(trim($row['rustdesk_id']))) {
                    $rd_id = trim($row['rustdesk_id']);
                }

                // 2. Si no tiene ID (es una incidencia automÃ¡tica), buscamos en el inventario
                if (!$rd_id) {
                    $nombre_incidencia = mysqli_real_escape_string($conexion, $row['nombre']);
                    $sql_pc = "SELECT rustdesk_id FROM dispositivos WHERE nombre_pc = '$nombre_incidencia' LIMIT 1";
                    $res_pc = mysqli_query($conexion, $sql_pc);
                    
                    if ($res_pc && mysqli_num_rows($res_pc) > 0) {
                        $fila_pc = mysqli_fetch_assoc($res_pc);
                        if (!empty($fila_pc['rustdesk_id'])) {
                            $rd_id = $fila_pc['rustdesk_id'];
                        }
                    }
                }
                ?>
                
                <div class="card <?php echo $clase; ?> tarjeta-incidencia">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                        <form method="POST">
                            <input type="hidden" name="id_incidencia" value="<?php echo $row['id']; ?>">
                            <select name="nuevo_estado" onchange="this.form.submit()" style="border-radius:20px; border:none; background:#f1f5f9; padding:5px 10px; font-weight:700; cursor:pointer; font-size: 0.8rem;">
                                <option value="Pendiente" <?php if($row['estado']=='Pendiente') echo 'selected'; ?>>ðŸ”´ Pendiente</option>
                                <option value="En proceso" <?php if($row['estado']=='En proceso') echo 'selected'; ?>>ðŸŸ¡ En proceso</option>
                                <option value="Resuelta" <?php if($row['estado']=='Resuelta') echo 'selected'; ?>>ðŸŸ¢ Resuelta</option>
                            </select>
                        </form>
                    </div>
                    
                    <p class="info"><b>ID Incid.:</b> #<?php echo $row['id']; ?></p>
                    <p class="info"><b>Asunto:</b> <?php echo htmlspecialchars($row['incidencia']); ?></p>
                    <p class="info"><b>Fecha:</b> <?php echo $row['fecha']; ?></p>
                    <p class="info"><b>ID Rust:</b> <?php echo $rd_id ? htmlspecialchars($rd_id) : 'No asignado'; ?></p>
                    
                    <div class="pie-tarjeta">
                        <?php if ($rd_id): 
                            // Limpiamos los espacios en blanco solo para el enlace interno
                            $id_limpio = str_replace(' ', '', $rd_id);
                        ?>
                            <a href="rustdesk://<?php echo htmlspecialchars($id_limpio); ?>" class="btn-rust">
                                ACCESO REMOTO (ID: <?php echo htmlspecialchars($rd_id); ?>)
                            </a>
                        <?php else: ?>
                            <div class="alerta-inventario">
                                âš ï¸ Equipo no vinculado en el sistema de inventario.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php 
            }
        } else {
            echo "<p style='text-align:center; grid-column: 1/-1;'>No hay incidencias activas.</p>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2026 Fixly - Yoel Vicente Caro y Carlos Alonso Seral (2Âº ASIR)[cite: 5]</p>
    </footer>

    <script>
        function filtrar() {
            let input = document.getElementById('buscador').value.toLowerCase();
            let items = document.getElementsByClassName('tarjeta-incidencia');
            for (let i = 0; i < items.length; i++) {
                let texto = items[i].innerText.toLowerCase();
                items[i].style.display = texto.includes(input) ? "flex" : "none";
            }
        }
    </script>
</body>
</html>
