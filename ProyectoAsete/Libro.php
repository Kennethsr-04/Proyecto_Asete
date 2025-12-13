<?php
require_once "Producto.php";
require_once "InfoComun.php";

class Libro extends Producto {

    use InfoComun;

    private $autorId;
    private $autorNombre;
    private $editorial;
    private $paginas;

    public function __construct($fila) {
        $this->id            = $fila["id"];
        $this->titulo        = $fila["Titulo"];
        $this->genero        = $fila["Genero"];
        $this->editorial     = $fila["Editorial"];
        $this->paginas       = $fila["Paginas"];
        $this->anio          = substr($fila["Año"], 0, 4);
        $this->precio        = $fila["Precio"];
        $this->autorId       = $fila["Autor_Id"];
        $this->autorNombre   = $fila["Autor_Nombre"] ?? "Desconocido";
    }
    
    public function getAutorId() {
        return $this->autorId;
    }
    
    public function getAutorNombre() {
        return $this->autorNombre;
    }
    
    public function getEditorial() {
        return $this->editorial;
    }
    
    public function getPaginas() {
        return $this->paginas;
    }

    public function getTipo() { return "libro"; }
}
?>
