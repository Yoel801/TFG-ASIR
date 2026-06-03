<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a Fixly</title>
    <link rel="stylesheet" href="../css/estilo_inicial_formulario.css">
    <!-- Importamos SweetAlert2 para alertas bonitas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <!-- Botón flotante superior derecho -->
    <button id="toggle-theme" class="btn-tema">🌙 Oscuro</button>

    <main>
        <section id="login">
            <h2>Acceso a Fixly</h2>
            
            <form id="formulario-login" action="registrardatos.php" method="post">
                <div class="grupo-input">
                    <label for="nombreUsuario">Correo electrónico</label>
                    <input type="text" id="nombreUsuario" name="nombre" placeholder="usuario@fixly.es" required>
                </div>
                
                <div class="grupo-input">
                    <label for="passUsuario">Contraseña</label>
                    <input type="password" id="passUsuario" name="password" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="boton_enviar">Iniciar Sesión</button>
            </form>

            <div class="zona-registro">
                <span>¿No tienes cuenta?</span> 
                <a href="registro.php" class="boton_registro">Registrarse</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Proyecto final - Todos los derechos reservados.</p>
        <p>Yoel Vicente Caro / Carlos Alonso Seral 2º ASIR</p>
    </footer>

    <!-- Cargamos la lógica del botón y validaciones -->
    <script src="../js/validaciones.js"></script>
</body>
</html>
