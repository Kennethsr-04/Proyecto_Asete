<?php
session_start();
require "db.php";
require "internacionalizacion.php";
require_once "Cliente.php";

$error = "";

$usuario = $_POST["usuario"] ?? "";
$contrasena = $_POST["contrasena"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cliente = Cliente::login($usuario, $contrasena);

    if ($cliente) {
        $_SESSION["usuario"] = $cliente["Nombre"];
        $_SESSION["id_cliente"] = $cliente["Id"];
        header("Location: catalogo.php");
        exit;
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
