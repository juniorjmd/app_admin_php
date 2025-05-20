<?php
namespace App\Models;
class Recurso
{
    public $id;
    public $nombre;
    public $descripcion;
    public $activo;
    public $direccion;
    public $crt_date;
    public $icono;
    public $tipo;
    public $padre;
    public $checked;
    public $hijos;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->nombre = $data['nombre'] ?? null;
        $this->descripcion = $data['descripcion'] ?? null;
        $this->activo = $data['activo'] ?? 1;  // Valor predeterminado 1
        $this->direccion = $data['direccion'] ?? null;
        $this->crt_date = $data['crt_date'] ?? null;
        $this->icono = $data['icono'] ?? null;
        $this->tipo = $data['tipo'] ?? 1;  // Valor predeterminado 1
        $this->padre = $data['padre'] ?? 0;  // Valor predeterminado 0
        $this->hijos = array();  // Valor predeterminado 0
    }

    // Otros métodos para manipular recursos pueden ir aquí
}
