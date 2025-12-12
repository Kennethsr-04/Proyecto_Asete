<?php
$password = "pedro"; // Cambia "pedro" por la contraseña que quieras
$hash = hash("sha256", $password . "SALT123");
echo $hash;
?>
