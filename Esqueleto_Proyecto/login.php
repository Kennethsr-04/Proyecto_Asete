<?php
session_start();
require "db.php";
require "internacionalizacion.php";

$error = "";

$usuario = $_POST["usuario"] ?? "";
$contrasena = $_POST["contrasena"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escapar el nombre de usuario para seguridad
    $usuario_esc = $conexion->real_escape_string($usuario);

    // Buscar usuario en la base de datos
    $resultado = $conexion->query("SELECT * FROM Clientes WHERE Nombre = '$usuario_esc' LIMIT 1");

    if ($resultado && $resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();

        // Generar hash de la contraseña ingresada
        $hash = hash("sha256", $contrasena);

        if ($hash === $cliente["Password"]) {
            // Login correcto, crear variables de sesión
            $_SESSION["usuario"] = $cliente["Nombre"];
            $_SESSION["id_cliente"] = $cliente["Id"];
            header("Location: catalogo.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyecto ASETE 1</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
    <?php include "caja-idiomas.html"; ?>

    <div class="caja-login">
        <h1><?=$traducciones["login"]?></h1>

        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="usuario"><?=$traducciones["user"]?></label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="clave"><?=$traducciones["pass"]?></label>
            <input type="password" name="contrasena" id="clave" required>

            <button type="submit"><?=$traducciones["enter"]?></button>
        </form>
    </div>
</body>
</html>
