<?php
$servidor = "bbdd";
$usuario = "root";
$contrasena = "bbdd";
$nombre_de_la_bbdd = "Peliculas";

$conexion = new mysqli($servidor, $usuario, $contrasena, $nombre_de_la_bbdd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Establecer UTF-8
$conexion->set_charset("utf8");

?>
