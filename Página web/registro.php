<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuarios</title>
    <link rel="stylesheet" href="estilo_registro.css">
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    if (empty($_POST['nombre'])) {
        $errors[] = "El campo nombre es obligatorio";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['nombre'])) {
        $errors[] = "El nombre solo puede contener letras y espacios";
    }
    if (empty($_POST['email'])) {
        $errors[] = "El campo email es obligatorio";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del email es inválido";
    }
    if (empty($_POST['password'])) {
        $errors[] = "El campo contraseña es obligatorio";
    } elseif (strlen($_POST['password']) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres";
    }
    if (empty($_POST['id_tarjeta'])) {
        $errors[] = "El campo id de la tarjeta es obligatorio";
    }
    if (empty($errors)) {
        echo "Formulario validado correctamente.";
    } else {
        foreach ($errors as $error) {
            echo "- " . $error . "<br>";
        }
    }
}
?>
<main>
    <section id="registro">
        <h2>Registro de usuarios</h2>
        <form action="registrardatosnuevos.php" method="post">
            Ingrese su nombre: <input type="text" name="nombre" size="20" required>
            <br>
            Ingrese su email: <input type="email" name="email" required>
            <br>
            Ingrese su contraseña: <input type="password" name="password" required>
            <br>
            Ingrese su id de la tarjeta: <input type="text" name="id_tarjeta" required>
            <br>
            <input class="boton_registro" type="submit" value="Registrarse">
        </form>
        <p class="boton_salida"><a href="formulario_inicial.php">Volver al formulario de inicio</a></p>
    </section>
</main>
</body>
</html>
