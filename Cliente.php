<?php
require_once "db.php";

class Cliente {

    private static $salt = "SALT123"; // puedes cambiarlo, pero mantenlo fijo

    public static function login($usuario, $password) {
        $db = DB::conectar();

        // Buscar usuario por nombre
        $sql = $db->prepare("SELECT * FROM Clientes WHERE Nombre = :u LIMIT 1");
        $sql->execute([":u" => $usuario]);
        $cliente = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            return false; // usuario no existe
        }

        // Validar contraseña cifrada
        $hash = hash("sha256", $password . self::$salt);

        if ($hash === $cliente["Password"]) {
            return $cliente; // login correcto
        }

        return false; // contraseña incorrecta
    }
}
