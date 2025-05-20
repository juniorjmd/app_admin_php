<?php
namespace App\Models;
class Perfil
{
    // Propiedades que representan las columnas de la tabla 'adm_perfil'
    public $id;
    public $nombre;
    public $activo;
    public $crt_date;
    public $permisos;

    // Constructor para inicializar las propiedades
   public function __construct($data = [])
            {
                $this->id = $data['id'] ?? null;
                $this->nombre = $data['nombre'] ?? null;
                $this->activo = $data['activo'] ?? 1;  // Valor predeterminado 1
                $this->crt_date = $data['crt_date'] ?? null;
                $this->permisos = $data['permisos'] ?? [];
            }
    // Método para obtener los permisos asociados a un perfil
    public function getPermisosPerfil()
    {
        // Suponiendo que los permisos se obtienen mediante una relación entre la tabla 'adm_perfil' y 'adm_perfil_recurso'
        $permisos = [];

        // Buscar los recursos asociados a este perfil
        $query = "SELECT r.id, r.nombre, r.descripcion, r.icono, r.tipo, r.padre
                  FROM adm_recurso r
                  JOIN adm_perfil_recurso pr ON pr.recurso = r.id
                  WHERE pr.perfil = :perfil_id AND pr.activo = 1";
        
        // Ejecución de la consulta y obtener los permisos
        // Asumiendo que tienes un método para ejecutar la consulta, como un DB::query() o PDO
        $result = DB::query($query, ['perfil_id' => $this->id]);

        // Si se encuentran permisos, devolverlos como un arreglo de objetos o arrays
        foreach ($result as $row) {
            $permisos[] = $row;  // O puedes crear un objeto Recurso si prefieres
        }

        return $permisos;
    }
}
