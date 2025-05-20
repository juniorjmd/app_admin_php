<?php 
namespace App\Models;

/**
 * Description of Folder
 *
 * @author JosédeJesúsDomínguez
 */ 

class Folder
{
    public $id;
    public $name;
    public $display_name;
    public $description;
    public $user;
    public $date_crt;
    public $id_wp;
    public $ruta_fisica;

    public function __construct($id = null, $name = null, $display_name = null, $description = null, $user = null, $date_crt = null , 
            $id_wp = 0 , $ruta_fisica = null
            )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->user = $user;
        $this->date_crt = $date_crt;
        $this->display_name = $display_name;
        $this->id_wp =$id_wp;
        $this->ruta_fisica = $ruta_fisica;
    }

    // Método para crear una carpeta desde un array
    public static function fromArray(array $data)
    {
        return new self(
            $data['id'] ?? null,
            $data['name'] ?? null,
            $data['display_name'] ?? null,
            $data['description'] ?? null,
            $data['user'] ?? null,
            $data['date_crt'] ?? null, 
            $data['id_wp'] ?? null,
            $data['ruta_fisica'] ?? null
        );
    }

    // Método para convertir la carpeta en un array (útil para JSON o bases de datos)
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name ,
            'description' => $this->description,
            'user' => $this->user,
            'date_crt' => $this->date_crt,
            'id_wp' => $this->id_wp,
            'ruta_fisica' => $this->ruta_fisica
        ];
    }
}
