<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

require "internacionalizacion.php";
require_once "db.php";
require_once "classes/Catalogo.php";

$catalogo = new Catalogo($conexion);

// Obtener parámetros de filtro
$tipo = $_GET['tipo'] ?? 'libros'; // 'libros' o 'peliculas'
$estado = $_GET['estado'] ?? 'todos'; // 'todos', 'disponibles', 'reservados'

// Obtener todos los libros y películas
$libros = $catalogo->obtenerLibros();
$peliculas = $catalogo->obtenerPeliculas();

// Filtrar según el estado
$items = [];
if ($tipo === 'peliculas') {
    foreach ($peliculas as $pelicula) {
        $disponible = $catalogo->isDisponiblePelicula($pelicula->getId());
        
        if ($estado === 'todos' || 
            ($estado === 'disponibles' && $disponible) ||
            ($estado === 'reservados' && !$disponible)) {
            $items[] = [
                'tipo' => 'pelicula',
                'objeto' => $pelicula,
                'disponible' => $disponible
            ];
        }
    }
} else {
    foreach ($libros as $libro) {
        $disponible = $catalogo->isDisponible($libro->getId());
        
        if ($estado === 'todos' || 
            ($estado === 'disponibles' && $disponible) ||
            ($estado === 'reservados' && !$disponible)) {
            $items[] = [
                'tipo' => 'libro',
                'objeto' => $libro,
                'disponible' => $disponible
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro por Estado - <?=$traducciones["titulo"]?></title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/filtro.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>🔍 Filtrar por Estado</h1>
    
    <div class="user-info">
        <span class="user-greeting">Bienvenido, <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></span></span>
        <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
    </div>

    <div class="filtro-estado">
        <h3>Selecciona tipo:</h3>
        <div class="switch-tipo">
            <a href="?tipo=libros&estado=<?=$estado?>" class="<?php echo $tipo === 'libros' ? 'activo' : ''; ?>">📚 Libros</a>
            <a href="?tipo=peliculas&estado=<?=$estado?>" class="<?php echo $tipo === 'peliculas' ? 'activo' : ''; ?>">🎬 Películas</a>
        </div>

        <h3>Filtrar por estado:</h3>
        <div class="filtro-grupo">
            <a href="?tipo=<?=$tipo?>&estado=todos" class="filtro-btn <?php echo $estado === 'todos' ? 'activo' : ''; ?>">
                Todos (<?php echo count($items); ?>)
            </a>
            <a href="?tipo=<?=$tipo?>&estado=disponibles" class="filtro-btn <?php echo $estado === 'disponibles' ? 'activo' : ''; ?>">
                Disponibles (<?php echo count(array_filter($items, fn($i) => $i['disponible'])); ?>)
            </a>
            <a href="?tipo=<?=$tipo?>&estado=reservados" class="filtro-btn <?php echo $estado === 'reservados' ? 'activo' : ''; ?>">
                Reservados (<?php echo count(array_filter($items, fn($i) => !$i['disponible'])); ?>)
            </a>
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="index.php" class="btn btn-secondary">← Volver</a>
    </div>

    <div class="contador">
        Mostrando <?php echo count($items); ?> resultado(s)
    </div>

    <?php if (empty($items)): ?>
        <div style="text-align: center; padding: 40px; background: #f9f9f9; border-radius: 8px;">
            <p style="color: #999; font-size: 16px;">No hay resultados que coincidan con los filtros seleccionados.</p>
            <a href="filtro_estado.php" class="btn" style="margin-top: 20px;">Resetear filtros</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <?php 
                    if ($item['tipo'] === 'libro') {
                        $libro = $item['objeto'];
                        $titulo = htmlspecialchars($libro->getTitulo());
                        $detalles = "Autor: " . htmlspecialchars($libro->getAutorNombre()) . " | " . htmlspecialchars($libro->getGenero());
                        $id = $libro->getId();
                        $disponible = $item['disponible'];
                        $enlace = "reservar_libro.php?id=" . $id;
                    } else {
                        $pelicula = $item['objeto'];
                        $titulo = htmlspecialchars($pelicula->getTitulo());
                        $detalles = "Director: " . htmlspecialchars($pelicula->getDirector()) . " | " . htmlspecialchars($pelicula->getGenero());
                        $id = $pelicula->getId();
                        $disponible = $item['disponible'];
                        $enlace = "reservar_pelicula.php?id=" . $id;
                    }
                    ?>
                    <tr>
                        <td><strong><?php echo $titulo; ?></strong></td>
                        <td style="font-size: 14px; color: #666;"><?php echo $detalles; ?></td>
                        <td>
                            <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; <?php echo $disponible ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;'; ?>">
                                <?php echo $disponible ? '✓ Disponible' : '✗ Reservado'; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($disponible): ?>
                                <a href="<?php echo $enlace; ?>" class="btn-accion" style="background: #28a745; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    Reservar
                                </a>
                            <?php else: ?>
                                <span class="btn-accion" style="background: #ccc; color: #666; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    Reservado
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
