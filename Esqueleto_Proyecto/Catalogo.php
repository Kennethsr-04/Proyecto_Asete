<?php
session_start();
require "internacionalizacion.php";

// Si no hay usuario logueado, redirige al login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

// Inicializar filtros
$genero = "";
$anio = "";
$director = "";

// Capturar filtros enviados por GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $genero  = $_GET["genero"] ?? "";
    $anio    = $_GET["año"] ?? "";
    $director = $_GET["director"] ?? "";

    // Guardar filtros en sesión
    $_SESSION["genero"]  = $genero;
    $_SESSION["año"]     = $anio;
    $_SESSION["director"] = $director;

} else {
    // Recuperar filtros desde sesión si no viene GET
    $genero  = $_SESSION["genero"] ?? "";
    $anio    = $_SESSION["año"] ?? "";
    $director = $_SESSION["director"] ?? "";
}

require_once "Catalogo.php";

// Obtener todas las películas desde la BBDD
$peliculas = Catalogo::obtenerPeliculas();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyecto ASETE 1</title>
    <link rel="stylesheet" href="style/catalogo.css">
    <link rel="stylesheet" href="style/idioma.css">
</head>
<body>

    <?php include "caja-idiomas.html"; ?>

    <h1><?= $traducciones["catalog"] ?></h1>

    <a href="filtro.php"><?= $traducciones["filter"] ?></a>
    <a href="agregar_peliculas.php" style="color: green;">
        <?= $traducciones["new_film"] ?>
    </a>

    <p>
        <?= $traducciones["user"] ?>: <?= $_SESSION['usuario']; ?>
        | <a href="logout.php"><?= $traducciones["logout"] ?></a>
    </p>

    <table>
        <tr>
            <th><?= $traducciones["title"] ?></th>
            <th><?= $traducciones["year"] ?></th>
            <th><?= $traducciones["director"] ?></th>
            <th><?= $traducciones["actors"] ?></th>
            <th><?= $traducciones["genre"] ?></th>
        </tr>

        <?php
        $contador = 0;

        foreach ($peliculas as $pelicula):

            // FILTROS EN PHP
            if (
                ($genero == "" || $pelicula->getGenero() == $genero) &&
                ($anio == "" || $pelicula->getAnio() == $anio) &&
                ($director == "" || stripos($pelicula->director, $director) !== false)
            ):
                $contador++;
        ?>
                <tr>
                    <td><?= $pelicula->getTitulo() ?></td>
                    <td><?= $pelicula->getAnio() ?></td>
                    <td><?= $pelicula->director ?></td>
                    <td><?= $pelicula->actores ?></td>
                    <td><?= $pelicula->getGenero() ?></td>
                </tr>

        <?php
            endif;
        endforeach;

        if ($contador == 0):
        ?>

            <tr>
                <td colspan="5">
                    No se ha encontrado ninguna película que coincida con la selección
                </td>
            </tr>

        <?php endif; ?>

    </table>

</body>
</html>
