<?php 

namespace App;

class Propiedad {
    public $id;
    public $titulo;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $create;
    public $vendedor_id;

    public function __construct($argc = [])
    {
        $this->id = $argc['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->create = $args['create'] ?? '';
        $this->vendedor_id = $args['vendedor_id'] ?? '';
        
    }
}