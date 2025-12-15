<?php
session_start();

// Si ya está autenticado, redirigir a inicio
if(isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit;
}

require "internacionalizacion.php";
require_once "db.php";

$mensaje = "";
$error = "";
$nombre = "";
$apellidos = "";
$fecha_nacimiento = "";
$localidad = "";
$usuario = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"] ?? "";
    $apellidos = $_POST["apellidos"] ?? "";
    $fecha_nacimiento = $_POST["fecha_nacimiento"] ?? "";
    $localidad = $_POST["localidad"] ?? "";
    $usuario = $_POST["usuario"] ?? "";
    $email = $_POST["email"] ?? "";
    $contrasena = $_POST["contrasena"] ?? "";
    $contrasena_conf = $_POST["contrasena_conf"] ?? "";
    
    // Validaciones
    if (empty($nombre) || empty($apellidos) || empty($fecha_nacimiento) || empty($localidad) || 
        empty($usuario) || empty($contrasena)) {
        $error = "Todos los campos son obligatorios.";
    } 
    elseif ($contrasena !== $contrasena_conf) {
        $error = "Las contraseñas no coinciden.";
    }
    elseif (strlen($contrasena) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    }
    else {
        // Verificar si el usuario ya existe
        $usuario_esc = $conexion->real_escape_string($usuario);
        $resultado = $conexion->query("SELECT * FROM Clientes WHERE Nombre = '$usuario_esc' LIMIT 1");
        
        if ($resultado && $resultado->num_rows > 0) {
            $error = "El nombre de usuario ya está registrado.";
        } 
        else {
            // Crear cliente nuevo
            $nombre_esc = $conexion->real_escape_string($nombre);
            $apellidos_esc = $conexion->real_escape_string($apellidos);
            $localidad_esc = $conexion->real_escape_string($localidad);
            $hash_contrasena = hash("sha256", $contrasena);
            
            $sql = "INSERT INTO Clientes (Nombre, Apellidos, Fecha_Nacimiento, Localidad, Password) 
                    VALUES ('$usuario_esc', '$apellidos_esc', '$fecha_nacimiento', '$localidad_esc', '$hash_contrasena')";
            
            if ($conexion->query($sql)) {
                // Auto-login después del registro
                $_SESSION['usuario'] = $usuario;
                $_SESSION['exito'] = "¡Registro exitoso! Bienvenido.";
                header("Location: index.php");
                exit;
            } else {
                $error = "Error al registrar: " . $conexion->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Videoclub-Biblioteca</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/register.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="caja-login">
    <h1>Crear Cuenta</h1>
    
    <?php if (!empty($mensaje)): ?>
        <div class="exito">✓ <?= htmlspecialchars($mensaje) ?><br><br><a href="login.php" style="color: #155724; text-decoration: underline;">Ir a iniciar sesión</a></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="error">✗ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre: <span style="color: red;">*</span></label>
                <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($nombre) ?>">
            </div>
            
            <div class="form-group">
                <label for="apellidos">Apellidos: <span>*</span></label>
                <input type="text" id="apellidos"quired value="<?= htmlspecialchars($apellidos) ?>">
            </div>
        </div>
        
        <div class="form-row full">
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento: <span>*</span></label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?= $fecha_nacimiento ?>">
            </div>
        </div>
        
        <div class="form-row full">
            <div class="form-group">
                <label for="localidad">Localidad/Provincia: <span>*</span></label>
                <input type="text" id="localidad" name="localidad" placeholder="Ej: Madrid, Barcelona, Valencia" required value="<?= htmlspecialchars($localidad) ?>">
            </div>
        </div>
        
        <div class="form-row full">
            <div class="form-group">
                <label for="usuario">Nombre de Usuario: <span>*</span></label>
                <input type="text" id="usuario" name="usuario" required value="<?= htmlspecialchars($usuario) ?>" placeholder="Único en el sistema">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="contrasena">Contraseña: <span>*</span></label>
                <input type="password" id="contrasena" name="contrasena" required onkeyup="verificarContrasenas()">
                <small>Mínimo 6 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="contrasena_conf">Confirmar Contraseña: <span>*</span></label>
                <input type="password" id="contrasena_conf" name="contrasena_conf" required onkeyup="verificarContrasenas()">
                <div id="password-match" class="password-match"></div>
            </div>
        </div>
        
        <button type="submit" style="width: 100%;">Registrarse</button>
    </form>
    
    <div class="register-link">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
    </div>
</div>

<script>
function verificarContrasenas() {
    const pass1 = document.getElementById('contrasena').value;
    const pass2 = document.getElementById('contrasena_conf').value;
    const indicator = document.getElementById('password-match');
    
    if (pass1 === '' || pass2 === '') {
        indicator.textContent = '';
        return;
    }
    
    if (pass1 === pass2) {
        indicator.textContent = '✓ Las contraseñas coinciden';
        indicator.className = 'password-match ok';
    } else {
        indicator.textContent = '✗ Las contraseñas no coinciden';
        indicator.className = 'password-match error';
    }
}
</script>

</body>
</html>
