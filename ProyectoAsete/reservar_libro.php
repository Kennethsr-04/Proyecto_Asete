<?php
session_start();
require_once "db.php";
require_once "internacionalizacion.php";
require_once "classes/Catalogo.php";

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Obtener ID del cliente
$usuario = $conexion->real_escape_string($_SESSION['usuario']);
$resultado = $conexion->query("SELECT id FROM Clientes WHERE Nombre = '$usuario' LIMIT 1");

if (!$resultado || $resultado->num_rows === 0) {
    die("Error: Cliente no encontrado");
}

$cliente = $resultado->fetch_assoc();
$id_cliente = $cliente['id'];

// Obtener ID del libro desde la URL
$id_libro = intval($_GET['id'] ?? 0);

if ($id_libro === 0) {
    header("Location: catalogo_libros.php");
    exit;
}

$catalogo = new Catalogo($conexion);
$libro = $catalogo->obtenerLibroPorId($id_libro);

if (!$libro) {
    die("Libro no encontrado");
}

// Procesar reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])) {
    $disponible = $catalogo->isDisponible($id_libro);
    
    if (!$disponible) {
        $error = "Este libro ya está reservado.";
    } else {
        if ($catalogo->reservarLibro($id_cliente, $id_libro)) {
            $_SESSION['exito'] = "¡Libro reservado exitosamente!";
            header("Location: mis_reservas.php");
            exit;
        } else {
            $error = "Error al reservar el libro. Intenta de nuevo.";
        }
    }
}

$disponible = $catalogo->isDisponible($id_libro);
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Libro - <?=$traducciones["titulo"]?></title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/reserva.css">
</head>
<body>
    <div class="contenedor-reserva">
        <h1>Reservar Libro</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="libro-preview">
            <div class="libro-titulo"><?php echo htmlspecialchars($libro->getTitulo()); ?></div>
            <div class="libro-detalles"><strong>Autor:</strong> <?php echo htmlspecialchars($libro->getAutor()); ?></div>
            <div class="libro-detalles"><strong>Género:</strong> <?php echo htmlspecialchars($libro->getGenero()); ?></div>
            <div class="libro-detalles"><strong>Editorial:</strong> <?php echo htmlspecialchars($libro->getEditorial()); ?></div>
            <div class="libro-detalles"><strong>Páginas:</strong> <?php echo htmlspecialchars($libro->getPaginas()); ?></div>
            <div class="libro-detalles"><strong>Precio:</strong> €<?php echo htmlspecialchars($libro->getPrecio()); ?></div>

            <div class="disponibilidad <?php echo $disponible ? 'si' : 'no'; ?>">
                <?php echo $disponible ? '✓ Disponible para reservar' : '✗ No disponible'; ?>
            </div>
        </div>

        <?php if ($disponible): ?>
            <div class="confirmacion">
                <strong>¿Deseas reservar este libro?</strong><br>
                Podrás recogerlo cuando lo retires del catálogo.
            </div>

            <form method="POST" class="formulario-reserva">
                <p>Al reservar este libro, se agregará a tu lista de reservas activas. Podrás devolverlo desde la sección "Mis Reservas".</p>
                
                <div class="btn-grupo">
                    <button type="submit" name="reservar" value="1" class="btn-reservar">
                        Confirmar Reserva
                    </button>
                    <a href="catalogo_libros.php" class="btn-volver">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <div class="formulario-reserva">
                <p style="color: #721c24; font-weight: bold;">Este libro ya está reservado por otro usuario. Intenta con otro libro.</p>
                
                <a href="catalogo_libros.php" class="btn-volver" style="display: block; margin-top: 10px;">Volver al Catálogo</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
