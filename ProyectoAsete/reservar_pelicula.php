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

// Obtener ID de la película desde la URL
$id_pelicula = intval($_GET['id'] ?? 0);

if ($id_pelicula === 0) {
    header("Location: Catalogo.php");
    exit;
}

$catalogo = new Catalogo($conexion);
$pelicula = $catalogo->obtenerPeliculaPorId($id_pelicula);

if (!$pelicula) {
    die("Película no encontrada");
}

// Procesar reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])) {
    $disponible = $catalogo->isDisponiblePelicula($id_pelicula);
    
    if (!$disponible) {
        $error = "Esta película ya está reservada.";
    } else {
        if ($catalogo->reservarPelicula($id_cliente, $id_pelicula)) {
            $_SESSION['exito'] = "¡Película reservada exitosamente!";
            header("Location: mis_reservas.php");
            exit;
        } else {
            $error = "Error al reservar la película. Intenta de nuevo.";
        }
    }
}

$disponible = $catalogo->isDisponiblePelicula($id_pelicula);
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Película - <?=$traducciones["titulo"]?></title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/reserva.css">
</head>
<body>
    <div class="contenedor-reserva">
        <h1>Reservar Película</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="pelicula-preview">

            <div class="pelicula-detalles"><strong>Duración:</strong> N/D</div>
            <div class="pelicula-detalles"><strong>Director:</strong> <?php echo htmlspecialchars($pelicula->getDirector()); ?></div>
            <div class="pelicula-detalles"><strong>Género:</strong> <?php echo htmlspecialchars($pelicula->getGenero()); ?></div>
            <div class="pelicula-detalles"><strong>Duración:</strong> <?php echo htmlspecialchars($pelicula->getDuracion()); ?> minutos</div>
            <div class="pelicula-detalles"><strong>Formato:</strong> <?php echo htmlspecialchars($pelicula->getFormato()); ?></div>
            <div class="pelicula-detalles"><strong>Precio:</strong> €<?php echo htmlspecialchars($pelicula->getPrecio() ?? 0); ?></div>
            
            <div class="disponibilidad <?php echo $disponible ? 'si' : 'no'; ?>">
                <?php echo $disponible ? '✓ Disponible para reservar' : '✗ No disponible'; ?>
            </div>
        </div>

        <?php if ($disponible): ?>
            <div class="confirmacion">
                <strong>¿Deseas reservar esta película?</strong><br>
                Podrás recogerla cuando la retires del catálogo.
            </div>

            <form method="POST" class="formulario-reserva">
                <p>Al reservar esta película, se agregará a tu lista de reservas activas. Podrás devolverla desde la sección "Mis Reservas".</p>
                
                <div class="btn-grupo">
                    <button type="submit" name="reservar" value="1" class="btn-reservar">
                        Confirmar Reserva
                    </button>
                    <a href="Catalogo.php" class="btn-volver">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <div class="formulario-reserva">
                <p style="color: #721c24; font-weight: bold;">Esta película ya está reservada por otro usuario. Intenta con otra película.</p>
                
                <a href="Catalogo.php" class="btn-volver" style="display: block; margin-top: 10px;">Volver al Catálogo</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
