<?php
require_once "Producto.php";
require_once "InfoComun.php";

class Pelicula extends Producto {

    use InfoComun;

    private $director;
    private $actores;
    private $tipoAdaptacion;
    private $adaptacionId;

    public function __construct($fila) {
        $this->id         = $fila["ID"];
        $this->titulo     = $fila["Título"];
        $this->genero     = $fila["Género"];
        $this->director   = $fila["Director"];
        $this->actores    = $fila["Actores"];
        $this->anio       = substr($fila["Año_estreno"], 0, 4);
        $this->precio     = null; // no tiene precio
        $this->tipoAdaptacion = $fila["Tipo_adaptación"];
        $this->adaptacionId   = $fila["Adaptación_ID"];
    }

    public function getTipo() { return "pelicula"; }
}
?>
