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
    <link rel="stylesheet" href="style/idioma.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 250px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .card-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .card h2 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
        }
        
        .card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .card.movies {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .card.books {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .welcome h2 {
            margin: 0 0 0.5rem 0;
        }
        
        .welcome p {
            margin: 0;
            font-size: 1.1rem;
        }
    </style>
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
