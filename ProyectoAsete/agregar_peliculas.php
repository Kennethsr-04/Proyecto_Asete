<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

require "internacionalizacion.php";
require_once "db.php";
require_once "classes/Catalogo.php";

$mensaje = "";
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $titulo = $_POST["titulo"] ?? "";
    $anio = $_POST["anio"] ?? "";
    $director = $_POST["director"] ?? "";
    $actores = $_POST["actores"] ?? "";
    $genero = $_POST["genero"] ?? "";

    // Validar campos obligatorios
    if (empty($titulo) || empty($anio) || empty($director) || empty($genero)) {
        $mensaje = "Todos los campos obligatorios deben estar completos.";
        $error = true;
    } else {
        // Usar la clase Catalogo para insertar en la BD
        $catalogo = new Catalogo($conexion);
        if ($catalogo->agregarPelicula($titulo, $anio, $director, $actores, $genero)) {
            $mensaje = "Película añadida correctamente a la base de datos.";
            $error = false;
            // Limpiar formulario
            $titulo = $anio = $director = $actores = $genero = "";
        } else {
            $mensaje = "Error al añadir la película a la base de datos.";
            $error = true;
        }
    }
}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $traducciones["add_new_film"] ?></title>
    <link rel="stylesheet" href="style/agregar_pelicula.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1><?= $traducciones["add_new_film"] ?></h1>
    
    <div class="user-info">
        <span><?= $traducciones["user"] ?>: <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></span></span>
        <a href="Catalogo.php" class="btn btn-secondary">Volver al Catálogo</a>
    </div>

    <?php if(!empty($mensaje)): ?>
        <div class="message <?= $error ? 'error' : 'success' ?>">
            <?= $error ? '✗' : '✓' ?> <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-container">
        <div class="form-group">
            <label for="titulo"><?= $traducciones["title"] ?>: <span class="required">*</span></label>
            <input type="text" name="titulo" id="titulo" required value="<?= htmlspecialchars($_POST["titulo"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="anio"><?= $traducciones["year"] ?>: <span class="required">*</span></label>
            <input type="number" name="anio" id="anio" required min="1900" max="2100" value="<?= htmlspecialchars($_POST["anio"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="director"><?= $traducciones["director"] ?>: <span class="required">*</span></label>
            <input type="text" name="director" id="director" required value="<?= htmlspecialchars($_POST["director"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="actores"><?= $traducciones["actors"] ?>:</label>
            <input type="text" name="actores" id="actores" value="<?= htmlspecialchars($_POST["actores"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="genero"><?= $traducciones["genre"] ?>: <span class="required">*</span></label>
            <select name="genero" id="genero" required>
                <option value="">-- Seleccionar --</option>
                <option value="Drama" <?= (($_POST["genero"] ?? "") == "Drama") ? "selected" : "" ?>>Drama</option>
                <option value="Romance" <?= (($_POST["genero"] ?? "") == "Romance") ? "selected" : "" ?>>Romance</option>
                <option value="Biografía" <?= (($_POST["genero"] ?? "") == "Biografía") ? "selected" : "" ?>>Biografía</option>
                <option value="Ciencia ficción" <?= (($_POST["genero"] ?? "") == "Ciencia ficción") ? "selected" : "" ?>>Ciencia ficción</option>
                <option value="Fantasía" <?= (($_POST["genero"] ?? "") == "Fantasía") ? "selected" : "" ?>>Fantasía</option>
                <option value="Animación" <?= (($_POST["genero"] ?? "") == "Animación") ? "selected" : "" ?>>Animación</option>
                <option value="Thriller" <?= (($_POST["genero"] ?? "") == "Thriller") ? "selected" : "" ?>>Thriller</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $traducciones["save_film"] ?></button>
            <a href="Catalogo.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>
