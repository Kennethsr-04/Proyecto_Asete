<?php
require_once "Producto.php";
require_once "InfoComun.php";

class Libro extends Producto {

    use InfoComun;

    private $autorId;
    private $autorNombre;
    private $editorial;
    private $paginas;

    public function __construct(array $fila) {

    $this->id        = $fila["Id"]        ?? $fila["id"]        ?? null;
    $this->titulo    = $fila["Titulo"]    ?? $fila["titulo"]    ?? "";
    $this->genero    = $fila["Genero"]    ?? $fila["genero"]    ?? "";
    $this->editorial = $fila["Editorial"] ?? $fila["editorial"] ?? "";
    $this->paginas   = $fila["Paginas"]   ?? $fila["paginas"]   ?? 0;
    $this->precio    = $fila["Precio"]    ?? $fila["precio"]    ?? null;

    $anioCompleto = $fila["Año"] ?? $fila["anio"] ?? null;
    $this->anio = $anioCompleto ? substr($anioCompleto, 0, 4) : "";

    $this->autorId =
        $fila["Autor_Id"] ?? $fila["autor_id"] ?? null;

    $this->autorNombre =
        $fila["Autor_Nombre"] ?? $fila["autor_nombre"] ?? "Desconocido";
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
