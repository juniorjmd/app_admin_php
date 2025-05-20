<?php 
namespace App\Repositories;   
use App\Models\Perfil;
use App\Models\Recurso;
use Core\helper;
use PDO; 
class PerfilRepository { 
    
    private $conn;
    private $table_name = "adm_perfil";

    public function __construct($db) {
        $this->conn = $db;
    }
     
  
    // Leer todos los usuarios
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query);
        $stmt->execute();
        $array =  $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->closeCursor();
        $perfiles = [];
        foreach ($array as $row) {
             $perfiles[] = new Perfil($row);
        }
    return $perfiles;  
        
        }

    // Leer un solo usuario por ID
    public function readById( $id ) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $link = $this->conn->getLink();
        $stmt = $link->prepare($query); 
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row['permisos'] = $this->getPermisosPerfil($id); 
        if ($row) {
            return new Perfil($row);
        } 
        return null;
    }
    
    public function getPermisosbyDad($id = 0){
         $query = "SELECT * FROM adm_recurso WHERE activo = true and  padre = ?  "; 
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query); 
        $stmt->bindParam(1, $id);
        $stmt->execute(); 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $recursos = [];
        foreach ($result as $row) $recursos[] = new Recurso($row); // Crear un objeto Recurso por cada fila  
        return $recursos; 
    } 
     
     private function getPermisosPerfil($id ){
         $query = "SELECT recurso FROM adm_perfil_recurso WHERE activo = true and  perfil = ?  "; 
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query); 
        $stmt->bindParam(1, $id);
        $stmt->execute(); 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        return  array_map(fn($x) => $x['recurso'], $result);
     }  
    public function changeState($id_perfil, $estado) {
          try { 
            // Conexión a la base de datos 
            $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
            $link->beginTransaction(); 
            // Llamada al procedimiento almacenado
            $consulta = $link->prepare("update adm_perfil set activo =  :_estado where id =  :_id_perfil  ");
             
            $consulta->bindParam(':_estado', $estado);
            $consulta->bindParam(':_id_perfil', $id_perfil); 
            $consulta->execute();  
            if ($consulta->execute()) {  
                  $link->commit();
                return  true ; } 
                                 else { return false ; } 
           } 
            catch (Exception $e) { 
                helper::log( $e->getMessage());
                $link->rollBack();
                throw $e; 
        }
    }
    public function updateAndSetPermisos($id_perfil, $nombre, $permisos = []) {
    try {
        $sql='';
        // Conexión a la base de datos
        $link = $this->conn->getLink();

        // Inicia la transacción
        $link->beginTransaction();

        // Actualiza el nombre del perfil
        $consulta = $link->prepare("
            UPDATE adm_perfil 
            SET nombre = :_nombre 
            WHERE id = :_id_perfil
        ");
        $consulta->bindParam(':_nombre', $nombre);
        $consulta->bindParam(':_id_perfil', $id_perfil);

        if (!$consulta->execute()) {
            throw new Exception("Error al actualizar el perfil.");
        }

        // Elimina los permisos existentes
        $consulta = $link->prepare("
            DELETE FROM adm_perfil_recurso 
            WHERE perfil = :_id_perfil
        ");
        $consulta->bindParam(':_id_perfil', $id_perfil);

        if (!$consulta->execute()) {
            helper::log( "Error al eliminar los permisos anteriores." );
            throw new Exception("Error al eliminar los permisos anteriores.");
        }

        // Inserta los nuevos permisos 
        $values = []; 
            foreach ($permisos as $id_permiso) {
                $values[] = "($id_perfil, $id_permiso)";
            }
        $cadena = 'Sin permisos agregados';
        if (!empty( $values) ) { 
        $sql = "INSERT INTO adm_perfil_recurso (perfil, recurso) VALUES " . implode(',', $values);
         $consulta = $link->prepare($sql);
         if (!$consulta->execute()) {
             
            helper::log( "Error al insertar el permiso $id_permiso.");
                throw new Exception("Error al insertar el permiso $id_permiso.");
            }
        // Genera el log de cambios
        $cadena = implode(', ', $permisos);
        }
        $this->log_cambios("usuario modificador => {$_SESSION['UsuarioActivo']->id } - {$_SESSION['UsuarioActivo']->name } , perfil : {$nombre} - Id: {$id_perfil} Permisos guardados => ($cadena)");

        // Confirma la transacción
        $link->commit();

        return true;
    } catch (Exception $e) {
        // Realiza rollback en caso de error
        $link->rollBack();  
        helper::log( $e->getMessage() - $sql);
        throw $e;
    }
} 
    private function log_cambios($errorMessage) {
    $logFile = "local.admin.aaa.com.perfilCambios.log";
    $timestamp = date("Y-m-d H:i:s"); // Fecha y hora actual
    $trace = debug_backtrace(); // Obtener información de la pila de llamadas
    $caller = $trace[0]; // La primera llamada al método actual

    // Construir el mensaje con la fecha, hora, archivo y línea
    $formattedMessage = sprintf(
        "[%s] %s in %s on line %d\n",
        $timestamp,
        $errorMessage,
        $caller['file'] ?? 'unknown file',
        $caller['line'] ?? 0
    );

    error_log($formattedMessage, 3, $logFile); // Escribir en el archivo sin sobrescribir
}   
}
