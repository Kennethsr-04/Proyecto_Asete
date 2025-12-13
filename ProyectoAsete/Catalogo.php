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
    unset($_SESSION["genero"]);
    unset($_SESSION["anio"]);
    unset($_SESSION["director"]);
    header("Location: Catalogo.php");
    exit;
}

// Obtener parámetros de filtro
$genero = $_SESSION["genero"] ?? "";
$anio = $_SESSION["anio"] ?? "";
$director = $_SESSION["director"] ?? "";

// Si viene del formulario, guardar los filtros
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["genero"] = $_GET["genero"] ?? "";
    $_SESSION["anio"] = $_GET["anio"] ?? "";
    $_SESSION["director"] = $_GET["director"] ?? "";
    
    $genero = $_SESSION["genero"];
    $anio = $_SESSION["anio"];
    $director = $_SESSION["director"];
}

// Obtener películas de la BD
$catalogo = new Catalogo($conexion);
$peliculas = $catalogo->obtenerPeliculas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>🎬 Catálogo de Películas</h1>
    
    <div class="toolbar">
        <a href="filtro.php" class="btn btn-filter">🔍 Filtrar</a>
        <a href="Catalogo.php?clear=1" class="btn btn-secondary">↺ Limpiar Filtros</a>
        <a href="agregar_peliculas.php" class="btn btn-add">➕ Añadir Película</a>
        <a href="catalogo_libros.php" class="btn btn-secondary">📚 Ver Libros</a>
        <a href="index.php" class="btn btn-secondary">🏠 Inicio</a>
    </div>
    
    <div class="user-info">
        <span class="user-greeting"><?= $traducciones["user"] ?? "Usuario" ?>: <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></span></span>
        <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
    </div>

    <table>
        <thead>
            <tr>
                <th><?= $traducciones["title"] ?></th>
                <th><?= $traducciones["year"] ?></th>
                <th><?= $traducciones["director"] ?></th>
                <th><?= $traducciones["actors"] ?></th>
                <th><?= $traducciones["genre"] ?></th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;
            foreach ($peliculas as $pelicula):
                // Aplicar filtros
                if (
                    ($genero == "" || $pelicula->getGenero() == $genero) &&
                    ($anio == "" || $pelicula->getAnio() == $anio) &&
                    ($director == "" || stripos($pelicula->getDirector(), $director) !== false)
                ):
                    $contador++;
                    $disponible = $catalogo->isDisponiblePelicula($pelicula->getId());
            ?>
                <tr>
                    <td><?= htmlspecialchars($pelicula->getTitulo()) ?></td>
                    <td><?= $pelicula->getAnio() ?></td>
                    <td><?= htmlspecialchars($pelicula->getDirector()) ?></td>
                    <td><?= htmlspecialchars($pelicula->getActores()) ?></td>
                    <td><?= htmlspecialchars($pelicula->getGenero()) ?></td>
                    <td>
                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; <?php echo $disponible ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;'; ?>">
                            <?php echo $disponible ? '✓ Disponible' : '✗ Reservado'; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($disponible): ?>
                            <a href="reservar_pelicula.php?id=<?php echo $pelicula->getId(); ?>" class="btn-accion" style="background: #28a745; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block;">
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
                    <td colspan="7" class="no-results">
                        No se encontraron películas que coincidan con los filtros seleccionados
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
