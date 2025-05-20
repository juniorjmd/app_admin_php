<?php 
namespace App\Controllers;

use Core\Controller; 
use Core\helper;
use App\Services\perfilService;
/**
 * Description of UserController
 *
 * @author JosédeJesúsDomínguez
 */ 
class PerfilController extends Controller {
    private $perfilService;
    public function __construct(perfilService $perfilService) { 
      $this->perfilService = $perfilService;
    }
    
    public function  index($id_perfil = 0  , $state = 0){
         switch ($_SERVER['REQUEST_METHOD']){
            case 'DELETE':    
                $this->perfilService->activate($id_perfil   , $state   );
            break; 
            case 'PUT':   
               //$this->perfilService->activate($id_perfil   , $state   );
            break; 
            case 'GET': 
                $this->home();
            break; 
        
            case 'PATCH': 
                  helper::parseJsonInput();
                $requiredParams = ['id_perfil' , 'nombre' , 'permisos'] ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                if (is_null($params)) {
                    http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
                } 
        
                $this->perfilService->agregarPermisos($params);
            break; 
            
           default :
               http_response_code(405); // Method Not Allowed
                helper::log( 'Método no permitido');
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            die();
        } 
    }
    
    private function home(){
        $data = [  
            'listaPerfil' => $this->perfilService->getAllPerfils()
            ]; 
        $this->view('perfil', $data); 
    }
    
    
    public function edit($id_perfil){
      $perfil = $this->perfilService->getPerfilById($id_perfil); // Obtener todos los permisos en jerarquía
      //print_r($perfil);
      $data = [
            'perfilEdit' =>$perfil ,
            'menu' =>  $this->perfilService->getPermisosRecursivosValidados(0 , $perfil->permisos) // Pasar la estructura a la vista
       ];
      $this->view('perfil/editPerfil', $data); 
    }

}
