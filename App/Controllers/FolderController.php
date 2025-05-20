<?php 
namespace App\Controllers; 
use Core\Controller;
use App\Repositories\FolderRepository;
use App\Models\Folder;
use Core\helper;
use App\Config;
use Core\DataBase;

class FolderController extends Controller
{
    private $folderService;

    public function __construct($folderService)
    {
        $this->folderService = $folderService;
    }

    public function index($id_folder = 0){
        switch ($_SERVER['REQUEST_METHOD']){
            case 'PUT': 
                $this->update();
                break; 
            case 'DELETE':   
                 $this->folderService->deleteFolder($id_folder );
                break; 
            case 'POST': 
              
                $requiredParams = ['crt_new_folder_name' , 'crt_new_folder_description' , 'crt_new_folder_display_name']  ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                   if (is_null($params)){
                       http_response_code(400);
                       echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
                       return;
                   } 
                   //$id = null, $name = null, $description = null, $user = null, $date_crt = null
                   $_folderArr = array(
                       "name" => $params['crt_new_folder_name'], 
                       "display_name" => $params['crt_new_folder_display_name'], 
                       "description" => $params['crt_new_folder_description'],  
                       "user" => $_SESSION['UsuarioActivo']->id   
                   );
                   $folder =  Folder::fromArray($_folderArr) ;    
                   $this->folderService->createNewFolder($folder);
                break;  
            case 'PATCH':
               // $this->setNewPass();
                break;  
            case 'GET':  
                $this->home();
            break;  
           default : 
               http_response_code(405); // Method Not Allowed
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido...']);
            die();
        } 
    }
    private function home(){
        $folders = $this->folderService->getAllFolder();
        $data = [ "folders" => $folders ]; 
        $this->view('folder', $data); 
    }
   
 
}
