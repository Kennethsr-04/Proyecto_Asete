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

$catalogo = new Catalogo($conexion);
$id_cliente = $_SESSION['id_cliente'] ?? null;

if (!$id_cliente) {
    $error = "Error al obtener datos del cliente.";
} else {
    // Obtener ID del cliente desde la BD
    $usuario = $conexion->real_escape_string($_SESSION['usuario']);
    $resultado = $conexion->query("SELECT id FROM Clientes WHERE Nombre = '$usuario' LIMIT 1");
    
    if ($resultado && $resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        $id_cliente = $cliente['id'];
    } else {
        $error = "No se encontró el cliente en la base de datos.";
    }
}

// Procesar devolución si se solicita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $id_reserva = intval($_POST['devolver']);
    $tipo = $_POST['tipo'] ?? '';
    
    // Obtener datos de la reserva
    $sql = "SELECT * FROM Reservas WHERE id = $id_reserva LIMIT 1";
    $res = $conexion->query($sql);
    
    if ($res && $res->num_rows > 0) {
        $reserva = $res->fetch_assoc();
        
        if ($tipo === 'libro') {
            $catalogo->devolverLibro($id_cliente, $reserva['Id_Libro']);
        } else {
            $catalogo->devolverPelicula($id_cliente, $reserva['Id_Pelicula']);
        }
        
        $_SESSION['exito'] = "Devolución registrada exitosamente.";
        header("Location: mis_reservas.php");
        exit;
    }
}

// Obtener reservas activas y completadas
$reservas_activas = $catalogo->obtenerReservasActivasCliente($id_cliente);
$historial = $catalogo->obtenerHistorialDevolucionesCliente($id_cliente);

$exito = $_SESSION['exito'] ?? '';
unset($_SESSION['exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - <?=$traducciones["titulo"]?></title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/mis_reservas.css">
</head>
<body>
    <div class="contenedor-reservas">
        <h1><?=$traducciones["reservas"] ?? "Mis Reservas"?></h1>

        <?php if ($exito): ?>
            <div class="exito"><?php echo $exito; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php else: ?>
            <!-- Reservas Activas -->
            <div class="seccion-reservas">
                <h2>Reservas Activas (<?=count($reservas_activas)?> item(s))</h2>
                
                <?php if (empty($reservas_activas)): ?>
                    <div class="mensaje-vacio">
                        No tienes reservas activas. <a href="index.php">Ir al catálogo</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($reservas_activas as $reserva): ?>
                        <?php
                        if ($reserva['libro_id']) {
                            $titulo = $reserva['libro_titulo'];
                            $subtitulo = "Por: " . ($reserva['Autor_Nombre'] ?? "Desconocido");
                            $tipo = "libro";
                            $tipo_label = "LIBRO";
                        } else {
                            $titulo = $reserva['pelicula_titulo'];
                            $subtitulo = "Director: " . ($reserva['pelicula_director'] ?? "Desconocido");
                            $tipo = "pelicula";
                            $tipo_label = "PELÍCULA";
                        }

                        $fecha_reserva = $reserva['Fecha_Reserva'] ? date('d/m/Y', strtotime($reserva['Fecha_Reserva'])) : 'N/D';
                        ?>
                        <div class="reserva-item">
                            <div class="reserva-info">
                                <span class="reserva-tipo <?=$tipo === 'pelicula' ? 'pelicula' : ''?>"><?=$tipo_label?></span>
                                <div class="reserva-titulo"><?php echo htmlspecialchars($titulo); ?></div>
                                <div style="color: #666; font-size: 14px;"><?php echo htmlspecialchars($subtitulo); ?></div>
                                <div class="reserva-fechas">
                                    <strong>Fecha de Reserva:</strong> <?=$fecha_reserva?>
                                </div>
                            </div>
                            <div class="reserva-acciones">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="devolver" value="<?=$reserva['id']?>">
                                    <input type="hidden" name="tipo" value="<?=$tipo?>">
                                    <button type="submit" class="btn-devolver" onclick="return confirm('¿Confirmar devolución?')">
                                        Devolver
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Historial de Devoluciones -->
            <div class="seccion-reservas">
                <h2>Historial de Devoluciones (<?=count($historial)?> item(s))</h2>
                
                <?php if (empty($historial)): ?>
                    <div class="mensaje-vacio">
                        No tienes historial de devoluciones.
                    </div>
                <?php else: ?>
                    <?php foreach ($historial as $reserva): ?>
                        <?php
                        if ($reserva['libro_id']) {
                            $titulo = $reserva['libro_titulo'];
                            $subtitulo = "Por: " . ($reserva['Autor_Nombre'] ?? "Desconocido");
                            $tipo_label = "LIBRO";
                        } else {
                            $titulo = $reserva['pelicula_titulo'];
                            $subtitulo = "Director: " . ($reserva['pelicula_director'] ?? "Desconocido");
                            $tipo_label = "PELÍCULA";
                        }

                        $fecha_reserva = $reserva['Fecha_Reserva'] ? date('d/m/Y', strtotime($reserva['Fecha_Reserva'])) : 'N/D';
                        $fecha_devolucion = $reserva['Fecha_Devolucion'] ? date('d/m/Y', strtotime($reserva['Fecha_Devolucion'])) : 'N/D';
                        $dias_tenido = ($reserva['Fecha_Reserva'] && $reserva['Fecha_Devolucion'])
                            ? (strtotime($reserva['Fecha_Devolucion']) - strtotime($reserva['Fecha_Reserva'])) / 86400
                            : 0;
                        ?>
                        <div class="reserva-item" style="background: #f5f5f5; opacity: 0.9;">
                            <div class="reserva-info">
                                <span class="reserva-tipo" style="background: #e8eaed; color: #5f6368;">DEVUELTO</span>
                                <div class="reserva-titulo"><?php echo htmlspecialchars($titulo); ?></div>
                                <div style="color: #666; font-size: 14px;"><?php echo htmlspecialchars($subtitulo); ?></div>
                                <div class="reserva-fechas">
                                    <strong>Reservado:</strong> <?=$fecha_reserva?> | 
                                    <strong>Devuelto:</strong> <?=$fecha_devolucion?> | 
                                    <strong>Duración:</strong> <?=intval($dias_tenido)?> día(s)
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <a href="index.php" class="enlace-inicio">Volver al inicio</a>
    </div>
</body>
</html>
