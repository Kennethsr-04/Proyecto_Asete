<?php
    $servidor = "bbdd";
    $usuario = "root";
    $contrasena = "bbdd";
    $nombre_de_la_bbdd = "Peliculas"; //Nombre de la Base de Datos en PHPMyAdmin dentro de Docker

    $conexion = new mysqli($servidor, $usuario, $contrasena, $nombre_de_la_bbdd);

    if($conexion->connect_error)
        echo "Conexión error:" . $conexion->connect_error;
    else   
        echo "Conectado sin error";
?>