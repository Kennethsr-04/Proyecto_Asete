<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

require "internacionalizacion.php";
require_once "db.php";
require_once "classes/Catalogo.php";

// Obtener valores guardados de la sesión
$genero = $_SESSION["genero_libro"] ?? "";
$autor = $_SESSION["autor_libro"] ?? "";
$anio = $_SESSION["anio_libro"] ?? "";

// Obtener lista de autores para el dropdown
$catalogo = new Catalogo($conexion);
$autores = $catalogo->obtenerAutores();

// Obtener géneros únicos de libros
$sql = "SELECT DISTINCT Genero FROM Libros ORDER BY Genero";
$resultado = $conexion->query($sql);
$generos = [];
while($fila = $resultado->fetch_assoc()){
    $generos[] = $fila["Genero"];
}

// Obtener años únicos de libros
$sql = "SELECT DISTINCT Año FROM Libros ORDER BY Año DESC";
$resultado = $conexion->query($sql);
$anos = [];
while($fila = $resultado->fetch_assoc()){
    $anos[] = $fila["Año"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Libros</title>
    <link rel="stylesheet" href="style/filtro.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>Filtrar Libros</h1>
    
    <form method="GET" action="catalogo_libros.php" class="filter-form">
        <div class="form-group">
            <label for="genero"><?= $traducciones["genre"] ?>:</label>
            <select name="genero" id="genero">
                <option value="">-- Todos --</option>
                <?php foreach($generos as $g): ?>
                    <option value="<?= htmlspecialchars($g) ?>" <?= ($genero == $g) ? "selected" : "" ?>>
                        <?= htmlspecialchars($g) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="autor">Autor:</label>
            <select name="autor" id="autor">
                <option value="">-- Todos --</option>
                <?php foreach($autores as $a): ?>
                    <option value="<?= htmlspecialchars($a["Nombre"]) ?>" 
                            <?= ($autor == $a["Nombre"]) ? "selected" : "" ?>>
                        <?= htmlspecialchars($a["Nombre"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="anio"><?= $traducciones["year"] ?>:</label>
            <select name="anio" id="anio">
                <option value="">-- Todos --</option>
                <?php foreach($anos as $y): ?>
                    <option value="<?= $y ?>" <?= ($anio == $y) ? "selected" : "" ?>>
                        <?= $y ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="catalogo_libros.php?clear=1" class="btn btn-secondary">Limpiar Filtros</a>
            <a href="catalogo_libros.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

</body>
</html>
