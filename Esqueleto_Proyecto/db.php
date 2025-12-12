<?php

/*
class DB {
    private static $conn = null;

    public static function conectar() {
        if (self::$conn === null) {
            $host = "bbdd";
            $dbname = "Peliculas";
            $user = "root";
            $pass = "root";

            self::$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}*/



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
