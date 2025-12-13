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
    <style>
        .contenedor-reserva {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .pelicula-preview {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .pelicula-titulo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .pelicula-detalles {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .disponibilidad {
            margin-top: 15px;
            padding: 15px;
            border-radius: 4px;
            font-weight: bold;
        }

        .disponibilidad.si {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .disponibilidad.no {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .formulario-reserva {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .formulario-reserva p {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .btn-grupo {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-reservar {
            flex: 1;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-reservar:hover:not(:disabled) {
            background: #218838;
        }

        .btn-reservar:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-volver {
            flex: 1;
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.3s;
        }

        .btn-volver:hover {
            background: #5a6268;
        }

        .confirmacion {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            color: #1565c0;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="contenedor-reserva">
        <h1>Reservar Película</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="pelicula-preview">
            <div class="pelicula-titulo"><?php echo htmlspecialchars($pelicula->getTitulo()); ?></div>
            <div class="pelicula-detalles"><strong>Director:</strong> <?php echo htmlspecialchars($pelicula->getDirector()); ?></div>
            <div class="pelicula-detalles"><strong>Género:</strong> <?php echo htmlspecialchars($pelicula->getGenero()); ?></div>
            <div class="pelicula-detalles"><strong>Duración:</strong> <?php echo htmlspecialchars($pelicula->getDuracion()); ?> minutos</div>
            <div class="pelicula-detalles"><strong>Formato:</strong> <?php echo htmlspecialchars($pelicula->getFormato()); ?></div>
            <div class="pelicula-detalles"><strong>Precio:</strong> €<?php echo htmlspecialchars($pelicula->getPrecio()); ?></div>

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
