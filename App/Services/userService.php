<?php 
namespace App\Services; 
use App\Repositories\UserRepository;
use App\Repositories\PerfilRepository;
use App\Models\User;
/**
 * Description of userService
 *
 * @author JosédeJesúsDomínguez
 */
class userService {  
    private $userRepository; 
    private $perfilRepository; 
    public function __construct(UserRepository $userRepository ,  PerfilRepository $perfilRepository )
    {
        $this->userRepository = $userRepository; 
        $this->perfilRepository =  $perfilRepository;
    }

    public function getAllUsers(){
        return $this->userRepository->read() ;
    }
     public function getAllFolders(){
        return $this->userRepository->readFolders() ;
    }
     public function getUserById($id){
        return  $this->userRepository->readById($id); 
    }
     public function getUserByNumId($id){
        return  $this->userRepository->readByNumId($id); 
    }
     public function getUserFolderById($id){
        return  $this->userRepository->readFolderById($id); 
    }
     public function getUserFolderByIdArray($usuario){
        $array =  $this->userRepository->readFolderById($usuario); 
        $id=[];
        foreach ($array as   $value) {
          $id[] =   $value->getMenu() ; 
        }
        return $id;
    }
    public function getAllPerfils(){
        return $this->perfilRepository->read() ;
    }
 

    public function getUserPermissions(int $userId): array
    {
        return $this->userRepository->getPermissionsByUserId($userId);
    }
    
     public function setRelationMenuUser($id_user , $id_menu   , $state){ 
        
        try { 
            if ($this->userRepository->changeRelationUserMenu($id_user , $id_menu   , $state)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos modificados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al cambiar la relacion del usuario con el menu']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        } 
    } 
     public function activate($userId, $estado){ 
        
        try { 
            if ($this->userRepository->changeStateUser($userId, $estado)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos modificados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estado al usuario']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        } 
    } 
    public function setNewPass(User $user){  
        try { 
            if ($this->userRepository->changePasswordUser($user)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos modificados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al cambiar la contraseña']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        
    }
    public function create(User $user){ 
       
        try { 
            if ($this->userRepository->insert_data_new_user($user)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos agregados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar nuevo usuario']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        
    }  
    public function updateUser( User $user ){  
        try { 
            if ($this->userRepository->update($user)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos agregados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar nuevo usuario']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        } 
}

}
