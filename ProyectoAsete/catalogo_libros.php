<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

require "internacionalizacion.php";
require_once "db.php";
require_once "classes/Catalogo.php";

// Si viene con parámetro clear, limpiar los filtros
if (isset($_GET['clear'])) {
    unset($_SESSION["genero_libro"]);
    unset($_SESSION["autor_libro"]);
    unset($_SESSION["anio_libro"]);
    header("Location: catalogo_libros.php");
    exit;
}

// Obtener parámetros de filtro
$genero = $_SESSION["genero_libro"] ?? "";
$autor = $_SESSION["autor_libro"] ?? "";
$anio = $_SESSION["anio_libro"] ?? "";

// Si viene del formulario, guardar los filtros
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["genero_libro"] = $_GET["genero"] ?? "";
    $_SESSION["autor_libro"] = $_GET["autor"] ?? "";
    $_SESSION["anio_libro"] = $_GET["anio"] ?? "";
    
    $genero = $_SESSION["genero_libro"];
    $autor = $_SESSION["autor_libro"];
    $anio = $_SESSION["anio_libro"];
}

// Obtener libros de la BD
$catalogo = new Catalogo($conexion);
$libros = $catalogo->obtenerLibros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros</title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>📚 Catálogo de Libros</h1>
    
    <div class="toolbar">
        <a href="filtro_libros.php" class="btn btn-filter">🔍 Filtrar</a>
        <a href="catalogo_libros.php?clear=1" class="btn btn-secondary">↺ Limpiar Filtros</a>
        <a href="agregar_libros.php" class="btn btn-add">➕ Añadir Libro</a>
        <a href="Catalogo.php" class="btn btn-secondary">🎬 Ver Películas</a>
        <a href="index.php" class="btn btn-secondary">🏠 Inicio</a>
    </div>
    
    <div class="user-info">
        <span class="user-greeting"><?= $traducciones["user"] ?? "Usuario" ?>: <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></span></span>
        <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th><?= $traducciones["year"] ?></th>
                <th><?= $traducciones["genre"] ?></th>
                <th>Páginas</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;
            foreach ($libros as $libro):
                // Aplicar filtros
                if (
                    ($genero == "" || $libro->getGenero() == $genero) &&
                    ($autor == "" || stripos($libro->getAutorNombre(), $autor) !== false) &&
                    ($anio == "" || $libro->getAnio() == $anio)
                ):
                    $contador++;
                    $disponible = $catalogo->isDisponible($libro->getId());
            ?>
                <tr>
                    <td><?= htmlspecialchars($libro->getTitulo()) ?></td>
                    <td><?= htmlspecialchars($libro->getAutorNombre()) ?></td>
                    <td><?= htmlspecialchars($libro->getEditorial()) ?></td>
                    <td><?= $libro->getAnio() ?></td>
                    <td><?= htmlspecialchars($libro->getGenero()) ?></td>
                    <td><?= $libro->getPaginas() ?></td>
                    <td><?= $libro->getPrecio() ?> €</td>
                    <td>
                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; <?php echo $disponible ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;'; ?>">
                            <?php echo $disponible ? '✓ Disponible' : '✗ Reservado'; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($disponible): ?>
                            <a href="reservar_libro.php?id=<?php echo $libro->getId(); ?>" class="btn-accion" style="background: #28a745; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block;">
                                Reservar
                            </a>
                        <?php else: ?>
                            <span class="btn-accion" style="background: #ccc; color: #666; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block; cursor: not-allowed;">
                                Reservado
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                endif;
            endforeach;

            if ($contador == 0):
            ?>
                <tr>
                    <td colspan="9" class="no-results">
                        No se encontraron libros que coincidan con los filtros seleccionados
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
