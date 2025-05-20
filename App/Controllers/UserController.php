<?php 

namespace App\Controllers;

use Core\Controller;  
use App\Services\userService;
use App\Models\User;
use Core\helper;
/**
 * Description of UserController
 *
 * @author JosédeJesúsDomínguez
 */
class UserController extends Controller { 
    
    
   private $userService;
   private $perfilRepository;
   
    
     public function __construct(userService $userService)
    {
        $this->userService = $userService;
    }
    public function index( $id_user = 0  , $state = 0 )
    {
        switch ($_SERVER['REQUEST_METHOD']){
            case 'PUT': 
                 helper::parseJsonInput();
                    $requiredParams = ['edit_user_name' ,  'edit_user_username' , 'edit_user_mail' ,  'edit_user_perfil' ,'edit_user_id'] ; 
                    $params = helper::validateAndAssignPostParameters($requiredParams); 
                    if (is_null($params)) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
                        return;
                    }

                    $user = new User([ 
                        "name" => $params['edit_user_name'],
                        "perfil" => $params['edit_user_perfil'],
                        "login" => $params['edit_user_username'],
                        "mail" => $params['edit_user_mail'] ,
                        "id" => $params['edit_user_id'] 
                    ]);
                     $this->userService->updateUser($user);
                break; 
            case 'DELETE':   
                $this->userService->activate($id_user   , $state   );
                break; 
            case 'POST':
                 $requiredParams = ['crt_new_usr_name' ,  'crt_new_usr_perfil' ,'crt_new_usr_numid', 'crt_new_usr_login' ,  'crt_new_usr_mail'  , 'crt_new_usr_pass' ] ; 
        $params = helper::validateAndAssignPostParameters($requiredParams); 
        if (is_null($params)){
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            return;
        }
        //$params['crt_new_usr_pass'] = password_hash($params['crt_new_usr_pass'], PASSWORD_BCRYPT);
        $params['crt_new_usr_pass'] = sha1($params['crt_new_usr_pass'] );
        $user = new User([
            "user_crt" => $_SESSION['UsuarioActivo']->id ,
            "name" => $params['crt_new_usr_name'],
            "perfil" => $params['crt_new_usr_perfil'],
            "login" => $params['crt_new_usr_login'],
            "mail" => $params['crt_new_usr_mail'],
            "hash" => $params['crt_new_usr_pass'],
            "numid" => $params['crt_new_usr_numid']
        ]); 
                $this->userService->create($user);
                break;  
            case 'PATCH':
                //echo 'llego aqui';
                    helper::parseJsonInput();
                    // 'edit_user_pass'    'edit_user_pass2'   'edit_user_id'   
                    $requiredParams = [  'edit_user_pass' ,'edit_user_pass' , 'edit_user_id' , 'accion_al_inicio'] ; 
                    $params = helper::validateAndAssignPostParameters($requiredParams); 
                    if (is_null($params)) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
                        return;
                    }

                    $user = new User([ 
                        "hash" => sha1($params['edit_user_pass']), 
                        "id" => $params['edit_user_id'] ,
                        "cambiar_pass" => ($params['accion_al_inicio'] === 'CAMBIOPSW')?true : false  ,
                    ]);
                $this->userService->setNewPass($user);
                break;  
            case 'GET': 
                $this->home();
            break; 
           default :
               http_response_code(405); // Method Not Allowed
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            die();
        } 
    } 
    public function validateNumId(){
           try {  
             helper::responseErrorIfTrue( ($_SERVER['REQUEST_METHOD'] !== 'POST') ,405 , 'Metodo invalido') ;   
             $params = helper::validateAndAssignPostParameters(['crt_new_usr_numid' ] ); 
             helper::responseErrorIfTrue(is_null($params) ,400 , 'Error en el servidor: Datos incompletos' ) ;   
             helper::responseErrorIfTrue(!is_null($this->userService->getUserByNumId($params['crt_new_usr_numid'])) ,200 , 'Usuario ya existe ') ;   
             helper::responseSuccess('numID disponible para creacion');
           }catch (\Throwable $e)
         {
          helper::responseErrorIfTrue(true ,503 , 'Error en el servidor: ' . $e->getMessage()) ;  
         }  
    }
    public function mUserMenuRel($id_user , $id_menu   , $state){
         $this->userService->setRelationMenuUser($id_user , $id_menu   , $state  );
        
    }
    public function edit( $id_param)
    {   
            $userEdit = $this->userService->getUserById($id_param); 
            $data = ['title' => 'Usuarios manager',
                'listaPerfil' => $this->userService->getAllPerfils() ,
                'userEdit' => $userEdit];  
            $this->view('user/editUser', $data);
         
    } 
  
    private function home(){
        $data = [
            'listaUser' => $this->userService->getAllUsers() , 
            'listaPerfil' => $this->userService->getAllPerfils()
            ]; 
        $this->view('user', $data); 
    }
     public function changeMyPass()
    {      
        $userEdit = $this->userService->getUserById($_SESSION['UsuarioActivo']->id); 
        $data = ['title' => 'Usuarios manager',  'habilitarCambio' => false , 
                'userEdit' => $userEdit];  
            $this->view('user/changeUserPassword', $data);
         
    }
    public function userFolder($id_param)
    {      
        $userEdit = $this->userService->getUserById($id_param);
        $userEditFolders = $this->userService->getUserFolderByIdArray($id_param); 
        $folders = $this->userService->getAllFolders($id_param);  
        $data = ['title' => 'Usuarios Folder manager',  
                'folders' => $folders , 
                'userEditFolders' => $userEditFolders,
                'userEdit' => $userEdit];  
            $this->view('user/manageUserFolder', $data);
         
    } 
     public function changePass( $id_param , $habilitarCambio  = true)
    {   
            $userEdit = $this->userService->getUserById($id_param); 
            $data = ['title' => 'Usuarios manager', 
                'habilitarCambio' => $habilitarCambio , 
                'userEdit' => $userEdit];  
            $this->view('user/changeUserPassword', $data);
         
    } 
}
