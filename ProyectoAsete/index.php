<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

require "internacionalizacion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub-Biblioteca - Inicio</title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>
<?php include "caja-idiomas.html"; ?>

<div class="container">
    <h1>🎬 Videoclub-Biblioteca</h1>
    
    <div class="user-info">
        <span class="user-greeting">Bienvenido, <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></span></span>
        <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
    </div>

    <div class="welcome">
        <h2>Bienvenido a tu Videoclub-Biblioteca</h2>
        <p>Selecciona una opción para comenzar:</p>
    </div>

    <div class="dashboard">
        <a href="Catalogo.php" class="card movies">
            <div class="card-icon">🎬</div>
            <h2>Películas</h2>
            <p>Ver y administrar tu colección de películas</p>
        </a>

        <a href="catalogo_libros.php" class="card books">
            <div class="card-icon">📚</div>
            <h2>Libros</h2>
            <p>Ver y administrar tu colección de libros</p>
        </a>

        <a href="mis_reservas.php" class="card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-icon">📋</div>
            <h2>Mis Reservas</h2>
            <p>Ver y gestionar tus reservas activas</p>
        </a>

        <a href="filtro_estado.php" class="card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
            <div class="card-icon">🔍</div>
            <h2>Filtrar por Estado</h2>
            <p>Buscar libros y películas disponibles</p>
        </a>
    </div>
</div>

</body>
</html>
