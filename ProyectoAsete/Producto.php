<?php
abstract class Producto {
    protected $id;
    protected $titulo;
    protected $genero;
    protected $anio;
    protected $precio;

    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getGenero() { return $this->genero; }
    public function getAnio() { return $this->anio; }
    public function getPrecio() { return $this->precio; }

    abstract public function getTipo();
}
?>
