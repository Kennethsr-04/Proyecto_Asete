<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

require "internacionalizacion.php";
require_once "db.php";
require_once "classes/Catalogo.php";

// Recuperar filtros de sesión
$genero = $_SESSION["genero"] ?? "";
$anio = $_SESSION["anio"] ?? "";
$director = $_SESSION["director"] ?? "";

// Obtener géneros únicos de películas para el dropdown
$catalogo = new Catalogo($conexion);
$sql = "SELECT DISTINCT Género FROM Peliculas ORDER BY Género";
$resultado = $conexion->query($sql);
$generos = [];
while($fila = $resultado->fetch_assoc()){
    $generos[] = $fila["Género"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Películas</title>
    <link rel="stylesheet" href="style/filtro.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>Filtrar películas</h1>

    <form method="GET" action="Catalogo.php" class="filter-form">
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
            <label for="anio"><?= $traducciones["year"] ?>:</label>
            <input type="number" name="anio" id="anio" min="1900" max="2100" placeholder="Ej: 2000" value="<?= $anio ?>">
        </div>

        <div class="form-group">
            <label for="director"><?= $traducciones["director"] ?>:</label>
            <input type="text" name="director" id="director" placeholder="Ej: Burton" value="<?= htmlspecialchars($director) ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $traducciones["filter"] ?></button>
            <a href="Catalogo.php?clear=1" class="btn btn-secondary">Limpiar Filtros</a>
            <a href="Catalogo.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>
</body>
</html>
