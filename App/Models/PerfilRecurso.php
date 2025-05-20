<?php
namespace App\Models;
class PerfilRecurso
{
    public $id;
    public $recurso;
    public $perfil;
    public $activo;
    public $crt_date;

    
        public function __construct($data = [])
        {
            $this->id = $data['id'] ?? null;
            $this->recurso = $data['recurso'] ?? null;
            $this->perfil = $data['perfil'] ?? null;
            $this->activo = $data['activo'] ?? 1;  // Valor predeterminado 1
            $this->crt_date = $data['crt_date'] ?? null;
        } 
}
