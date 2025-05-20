<?php
namespace App\Services; 
/**
 * Description of perfilService
 *
 * @author JosédeJesúsDomínguez
 */
use App\Repositories\PerfilRepository ; 
class perfilService {
    private $perfilRepository ; 
    public function __construct(PerfilRepository $perfilRepository) {
        $this->perfilRepository =   $perfilRepository; 
    }
    public function getAllPerfils(){
        return $this->perfilRepository->read() ;
    }
    public function getPerfilById($id){
        return $this->perfilRepository->readById($id) ;
    }
    public function activate($id_perfil, $estado){ 
        
        try { 
            if ($this->perfilRepository->changeState($id_perfil, $estado)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos modificados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estado']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            helper::log( $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        
    }
    
    
    public function getPermisosRecursivos($padreId = 0){
    $permisos = $this->perfilRepository->getPermisosbyDad($padreId);
    foreach ($permisos as &$permiso) {
        $permiso->hijos  = array();
        $permiso->hijos = $this->getPermisosRecursivos($permiso->id ); // Obtener hijos recursivamente
    }
    return $permisos;
}

    public function getPermisosRecursivosValidados($padreId = 0 , $p = array()) {
        $permisos = $this->perfilRepository->getPermisosbyDad($padreId);
        foreach ($permisos as &$permiso) {
            $permiso->checked = in_array($permiso->id, $p)?true:false;
            $permiso->hijos  = array();
            $permiso->hijos = $this->getPermisosRecursivosValidados($permiso->id , $p); // Obtener hijos recursivamente
        }
        return $permisos;
    }
    
    public function agregarPermisos($params){ 
      
        try { 
            //print_r($params);
            if ($this->perfilRepository->updateAndSetPermisos($params['id_perfil'] , $params['nombre'] ,( isset($params['permisos']))?$params['permisos']:[] )) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos actualizados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar nuevo permiso']); 
                helper::log( 'Error al ingresar nuevo permiso' );
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
                helper::log( $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            
        } 
        
    } 
}
