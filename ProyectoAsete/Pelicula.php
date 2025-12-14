<?php
require_once "Producto.php";
require_once "InfoComun.php";

class Pelicula extends Producto {

    use InfoComun;

    private $director;
    private $actores;
    private $tipoAdaptacion;
    private $adaptacionId;

    public function __construct(array $fila) {

    // Normalizamos claves (solución robusta)
    $this->id       = $fila["Id"]            ?? $fila["id"]            ?? null;
    $this->titulo   = $fila["Título"]        ?? $fila["titulo"]        ?? "";
    $this->genero   = $fila["Género"]        ?? $fila["genero"]        ?? "";
    $this->director = $fila["Director"]      ?? $fila["director"]      ?? "";
    $this->actores  = $fila["Actores"]       ?? $fila["actores"]       ?? "";

    $anioCompleto = $fila["Año_estreno"] ?? $fila["anio_estreno"] ?? null;
    $this->anio = $anioCompleto ? substr($anioCompleto, 0, 4) : "";

    $this->precio = null;

    $this->tipoAdaptacion =
        $fila["Tipo_adaptación"] ?? $fila["tipo_adaptacion"] ?? "";

    $this->adaptacionId =
        $fila["Adaptación_ID"] ?? $fila["adaptacion_id"] ?? null;
}

    public function getFormato() {
        return 'N/D'; // valor por defecto
    }
    public function getDuracion() {
        return 'N/D'; // o un valor fijo, por ejemplo 120
    }
    public function getDirector() {
        return $this->director;
    }
    
    public function getActores() {
        return $this->actores;
    }
    
    public function getTipoAdaptacion() {
        return $this->tipoAdaptacion;
    }
    
    public function getAdaptacionId() {
        return $this->adaptacionId;
    }

    public function getTipo() { return "pelicula"; }
}
?>
