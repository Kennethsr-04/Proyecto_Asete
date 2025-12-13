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
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar datos
    $titulo = $_POST["titulo"] ?? "";
    $autor_id = $_POST["autor_id"] ?? "";
    $genero = $_POST["genero"] ?? "";
    $editorial = $_POST["editorial"] ?? "";
    $paginas = $_POST["paginas"] ?? "";
    $anio = $_POST["anio"] ?? "";
    $precio = $_POST["precio"] ?? "";

    if (empty($titulo) || empty($autor_id) || empty($genero) || empty($editorial) || empty($paginas) || empty($anio) || empty($precio)) {
        $error = "Todos los campos son obligatorios";
    } else {
        $catalogo = new Catalogo($conexion);
        if ($catalogo->agregarLibro($titulo, $autor_id, $genero, $editorial, $paginas, $anio, $precio)) {
            $mensaje = "Libro añadido correctamente";
            // Limpiar el formulario
            $titulo = $autor_id = $genero = $editorial = $paginas = $anio = $precio = "";
        } else {
            $error = "Error al añadir el libro";
        }
    }
}

// Obtener lista de autores
$catalogo = new Catalogo($conexion);
$autores = $catalogo->obtenerAutores();

// Obtener géneros únicos
$sql = "SELECT DISTINCT Genero FROM Libros ORDER BY Genero";
$resultado = $conexion->query($sql);
$generos = [];
while($fila = $resultado->fetch_assoc()){
    $generos[] = $fila["Genero"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Libro</title>
    <link rel="stylesheet" href="style/agregar_pelicula.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>📚 Añadir Nuevo Libro</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="message success">
            ✓ <?= htmlspecialchars($mensaje) ?>
            <br>
            <a href="catalogo_libros.php" class="btn btn-primary">Ver Catálogo de Libros</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="message error">
            ✗ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form-container">
        <div class="form-group">
            <label for="titulo">Título del Libro: <span class="required">*</span></label>
            <input type="text" id="titulo" name="titulo" required value="<?= htmlspecialchars($_POST["titulo"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="autor_id">Autor: <span class="required">*</span></label>
            <select id="autor_id" name="autor_id" required>
                <option value="">-- Seleccionar autor --</option>
                <?php foreach($autores as $a): ?>
                    <option value="<?= $a["Id"] ?>" <?= (($_POST["autor_id"] ?? "") == $a["Id"]) ? "selected" : "" ?>>
                        <?= htmlspecialchars($a["Nombre"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="genero"><?= $traducciones["genre"] ?>: <span class="required">*</span></label>
            <select id="genero" name="genero" required>
                <option value="">-- Seleccionar género --</option>
                <?php foreach($generos as $g): ?>
                    <option value="<?= htmlspecialchars($g) ?>" <?= (($_POST["genero"] ?? "") == $g) ? "selected" : "" ?>>
                        <?= htmlspecialchars($g) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="editorial">Editorial: <span class="required">*</span></label>
            <input type="text" id="editorial" name="editorial" required value="<?= htmlspecialchars($_POST["editorial"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="paginas">Número de Páginas: <span class="required">*</span></label>
            <input type="number" id="paginas" name="paginas" required min="1" value="<?= htmlspecialchars($_POST["paginas"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="anio"><?= $traducciones["year"] ?>: <span class="required">*</span></label>
            <input type="number" id="anio" name="anio" required min="1900" max="2100" value="<?= htmlspecialchars($_POST["anio"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="precio">Precio (€): <span class="required">*</span></label>
            <input type="number" id="precio" name="precio" required min="0" step="0.01" value="<?= htmlspecialchars($_POST["precio"] ?? "") ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Libro</button>
            <a href="catalogo_libros.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>
