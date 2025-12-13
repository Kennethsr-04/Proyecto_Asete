<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Instalación - Videoclub-Biblioteca</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            max-width: 800px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .check-section {
            margin-bottom: 2rem;
            padding: 1rem;
            border-left: 4px solid #ccc;
            border-radius: 4px;
        }
        
        .check-section.success {
            border-left-color: #27ae60;
            background: #d5f4e6;
        }
        
        .check-section.error {
            border-left-color: #e74c3c;
            background: #fadbd8;
        }
        
        .check-section.warning {
            border-left-color: #f39c12;
            background: #fef5e7;
        }
        
        .check-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .icon {
            font-size: 1.2rem;
        }
        
        .check-message {
            color: #555;
            font-size: 0.9rem;
            margin-left: 1.7rem;
        }
        
        .file-list {
            list-style: none;
            margin-left: 1.7rem;
            margin-top: 0.5rem;
        }
        
        .file-list li {
            padding: 0.3rem 0;
            color: #666;
            font-family: monospace;
            font-size: 0.85rem;
        }
        
        .file-list li:before {
            content: "✓ ";
            color: #27ae60;
            font-weight: bold;
            margin-right: 0.5rem;
        }
        
        .file-list li.missing:before {
            content: "✗ ";
            color: #e74c3c;
        }
        
        .button-group {
            text-align: center;
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            margin: 0.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .summary {
            background: #ecf0f1;
            padding: 1.5rem;
            border-radius: 5px;
            margin-top: 2rem;
            text-align: center;
        }
        
        .summary-status {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .status-ready {
            color: #27ae60;
        }
        
        .status-error {
            color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🔍 Verificación de Instalación</h1>
    
    <?php
    $checks = array();
    $all_ok = true;
    
    // 1. Verificar PHP
    $checks[] = array(
        'title' => 'Versión de PHP',
        'status' => phpversion() >= '7.0' ? 'success' : 'error',
        'message' => 'PHP ' . phpversion() . ' (' . (phpversion() >= '8.0' ? 'Excelente! PHP 8+' : 'Compatible') . ')'
    );
    
    // 2. Verificar extensión MySQLi
    $mysqli_loaded = extension_loaded('mysqli');
    $checks[] = array(
        'title' => 'Extensión MySQLi',
        'status' => $mysqli_loaded ? 'success' : 'error',
        'message' => $mysqli_loaded ? 'MySQLi está instalada' : 'MySQLi no está disponible'
    );
    if (!$mysqli_loaded) $all_ok = false;
    
    // 3. Verificar archivo db.php
    $db_exists = file_exists('db.php');
    $checks[] = array(
        'title' => 'Archivo db.php',
        'status' => $db_exists ? 'success' : 'error',
        'message' => $db_exists ? 'Archivo de conexión encontrado' : 'Archivo db.php no existe'
    );
    if (!$db_exists) $all_ok = false;
    
    // 4. Intentar conexión a BD
    if ($db_exists) {
        try {
            require_once 'db.php';
            if ($conexion->connect_error) {
                $checks[] = array(
                    'title' => 'Conexión a Base de Datos',
                    'status' => 'error',
                    'message' => 'Error: ' . $conexion->connect_error
                );
                $all_ok = false;
            } else {
                $checks[] = array(
                    'title' => 'Conexión a Base de Datos',
                    'status' => 'success',
                    'message' => 'Conectado a la base de datos "Peliculas"'
                );
            }
        } catch (Exception $e) {
            $checks[] = array(
                'title' => 'Conexión a Base de Datos',
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            );
            $all_ok = false;
        }
    }
    
    // 5. Verificar archivos clave
    $required_files = array(
        'index.php',
        'login.php',
        'logout.php',
        'Catalogo.php',
        'catalogo_libros.php',
        'classes/Catalogo.php',
        'Pelicula.php',
        'Libro.php',
        'Producto.php',
        'internacionalizacion.php',
        'lang/es.php',
        'lang/en.php',
        'style/catalogo.css',
    );
    
    $missing_files = array();
    foreach ($required_files as $file) {
        if (!file_exists($file)) {
            $missing_files[] = $file;
        }
    }
    
    $files_ok = count($missing_files) == 0;
    $checks[] = array(
        'title' => 'Archivos Requeridos',
        'status' => $files_ok ? 'success' : 'error',
        'message' => $files_ok ? 
            'Todos los ' . count($required_files) . ' archivos están presentes' :
            count($missing_files) . ' archivo(s) faltante(s)',
        'files' => $missing_files
    );
    if (!$files_ok) $all_ok = false;
    
    // 6. Verificar carpetas
    $required_dirs = array('classes', 'lang', 'style', 'img');
    $missing_dirs = array();
    foreach ($required_dirs as $dir) {
        if (!is_dir($dir)) {
            $missing_dirs[] = $dir;
        }
    }
    
    $dirs_ok = count($missing_dirs) == 0;
    $checks[] = array(
        'title' => 'Carpetas Requeridas',
        'status' => $dirs_ok ? 'success' : 'error',
        'message' => $dirs_ok ? 
            'Todas las ' . count($required_dirs) . ' carpetas existen' :
            count($missing_dirs) . ' carpeta(s) faltante(s)',
        'files' => $missing_dirs
    );
    if (!$missing_dirs) $all_ok = false;
    
    // 7. Verificar sesiones
    $session_ok = ini_get('session.save_path') || session_save_path();
    $checks[] = array(
        'title' => 'Soporte de Sesiones',
        'status' => $session_ok ? 'success' : 'warning',
        'message' => 'Sesiones PHP ' . ($session_ok ? 'habilitadas' : 'pueden tener problemas')
    );
    
    // Mostrar resultados
    foreach ($checks as $check) {
        $icon = '';
        switch ($check['status']) {
            case 'success': $icon = '✓'; break;
            case 'error': $icon = '✗'; break;
            case 'warning': $icon = '⚠'; break;
        }
        ?>
        <div class="check-section <?= $check['status'] ?>">
            <div class="check-title">
                <span class="icon"><?= $icon ?></span>
                <?= htmlspecialchars($check['title']) ?>
            </div>
            <div class="check-message">
                <?= htmlspecialchars($check['message']) ?>
            </div>
            <?php if (!empty($check['files'])): ?>
                <ul class="file-list">
                    <?php foreach ($check['files'] as $file): ?>
                        <li class="missing"><?= htmlspecialchars($file) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php
    }
    ?>
    
    <div class="summary">
        <div class="summary-status <?= $all_ok ? 'status-ready' : 'status-error' ?>">
            <?= $all_ok ? '✓ Instalación Correcta' : '✗ Hay Problemas' ?>
        </div>
        <p>
            <?php if ($all_ok): ?>
                Tu Videoclub-Biblioteca está listo para usar. 
                <a href="login.php" style="color: #667eea; text-decoration: none;">Ir al login →</a>
            <?php else: ?>
                Revisa los errores marcados arriba y corrige los problemas antes de continuar.
            <?php endif; ?>
        </p>
    </div>
    
    <div class="button-group">
        <a href="login.php" class="btn btn-primary">Ir al Login</a>
        <a href="index.php" class="btn btn-secondary">Ir al Inicio</a>
        <button class="btn btn-secondary" onclick="location.reload()">Recargar</button>
    </div>
</div>

</body>
</html>
