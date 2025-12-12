<?php
require_once "Producto.php";
require_once "InfoComun.php";

class Libro extends Producto {

    use InfoComun;

    private $autor;
    private $editorial;
    private $paginas;

    public function __construct($fila) {
        $this->id       = $fila["id"];
        $this->titulo   = $fila["Titulo"];
        $this->genero   = $fila["Genero"];
        $this->editorial= $fila["Editorial"];
        $this->paginas  = $fila["Paginas"];
        $this->anio     = substr($fila["Año"], 0, 4);
        $this->precio   = $fila["Precio"];
        $this->autor    = $fila["Nombre"];
    }

    public function getTipo() { return "libro"; }
}
?>
