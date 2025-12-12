<?php
trait InfoComun {
    public function resumen() {
        return "{$this->titulo} ({$this->anio}) - {$this->genero}";
    }
}
?>
