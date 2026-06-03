<?php
$inc = include("conexionBBDD.php");
if ($inc) {
    $consulta = "SELECT * FROM incidencias";
    $resultado = mysqli_query($conex, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()) {
           $id = $row['id'];
           $nombre = $row['nombre'];
           $incidencia = $row['incidencia'];
           $fecha = $row['fecha'];
           ?>
           <div>
                <h2><?php echo $nombre; ?></h2>
                <div>
                    <p>
                        <b>ID: </b> <?php echo $id; ?> <br>
                        <b>Nombre: </b> <?php echo $nombre; ?> <br>
                        <b>Incidencia: </b> <?php echo $incidencia; ?> <br>
                        <b>Fecha: </b> <?php echo $fecha; ?> <br>
                    </p>
                    <a href="rustdesk://<?php echo $rustdesk_id; ?>">
                    	<buttom type="buttom" background-color:"gray">
			   Conectar a rustdesk
                    	</buttom>
                    </a>
                </div>
            </div>
        <?php
        }
    }
}
?>
