<?php 
namespace App\Controllers; 
use Core\Controller; 
use Core\helper;
use App\Services\contenidoService;

class ContenidoController extends Controller
{
    private $contenidoService;

    public function __construct(contenidoService $contenidoService)
    {
        $this->contenidoService = $contenidoService;
    }

    public function index($id_folder = 0){
        
        switch ($_SERVER['REQUEST_METHOD']){
            case 'PUT':  
                break; 
            case 'DELETE':  
               
                break; 
            case 'POST': 
               if (!empty($_FILES['files']['name'][0])) {
                   $allowedExtensions = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
                   if ( is_array($_FILES['files']['name']) ) {
                    foreach ($_FILES['files']['name'] as $index => $fileName) {
                        $extension = pathinfo($fileName, PATHINFO_EXTENSION); 
                        if (!in_array($extension, $allowedExtensions)) { 
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Archivo no permitido: '.$fileName]);
                        return;
                       }
                    }
                }else{
                     $extension = [pathinfo($_FILES['files']['name'][0], PATHINFO_EXTENSION)]; 
                        if (!in_array($extension, $allowedExtensions)) { 
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Archivo no permitido: '.$fileName]);
                        return;
                       }
                } 
                
                
                   
                    $path = $_POST['path'] ?? '';  
                    // Verificar si la ruta es válida
                    if (empty($path) || !is_dir($path)) { 
                        echo json_encode(['success' => false, 'message' => 'La ruta especificada no es válida']);
                        return;
                    } 
                $responses = []; 
                // Subir archivos
                    if ($this->uploadFile($responses, $path)) {
                        echo json_encode(['success' => true, 'message' => $responses]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error al procesar los archivos.']);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(['success' => false, 'message' => 'No se recibieron archivos.']);
                }
                break;  
            case 'PATCH':
               // $this->setNewPass();
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
    
private function uploadFile(&$responses, $path)
{
    foreach ($_FILES['files']['name'] as $key => $name) {
        $tmpName = $_FILES['files']['tmp_name'][$key];
        $targetFile = rtrim($path, '/') . '/' . basename($name);

        if (move_uploaded_file($tmpName, $targetFile)) {
            $responses[] = "Archivo subido exitosamente: $targetFile";
        } else {
            $responses[] = "Error al subir el archivo: $name";
        }
    }

    return !empty($responses); // Devuelve true si hubo al menos una respuesta
}
    public function directory(){ 
         $requiredParams = ['crt_new_folder_padre' , 'crt_new_folder_name' ] ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                if (is_null($params)) {
                    http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
                } 
        $this->createNewDir($params);     
    }
    
      public function chgNameDir(){
                $requiredParams = ['chg_nombre_dir_padre' , 'chg_nombre_dir_name' ] ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                if (is_null($params)) {
                    http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
                } 
                $this->renameDir($params);
    }
          public function chgNameFile(){
                $requiredParams = ['chg_nombre_file_padre','chg_nombre_file_name','chg_nombre_file_name_extension' ] ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                if (is_null($params)) {
                    http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
                } 
                $this->renameFile($params);
    }
    public function dltf(){
                $requiredParams = ['path' ] ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                if (is_null($params)) {
                    http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
                } 
                $this->deleteFile($params);
    }
      public function dltd(){
                $requiredParams = ['path' ] ; 
                $params = helper::validateAndAssignPostParameters($requiredParams); 
                if (is_null($params)) {
                    http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
                } 
                $this->deleteDir($params);
    }
    
    public function files($_id_folder){        
        $folderAcceso = $this->contenidoService->validateFolderBySessionKey($_SESSION['LLAVE_SESSION'] ,$_id_folder );
        $html = $this->contenidoService->getContenidoFolder($folderAcceso);
        $data = [ 'folderAcceso' => $html  ]; 
        $this->view('contenido/files', $data); 
    }
    
    private function createNewDir($param) {
         $this->contenidoService->createDir($param['crt_new_folder_padre'] , $param['crt_new_folder_name']  );
    }
    private function home(){
        $folders = $this->contenidoService->getFolderBySessionKey($_SESSION['LLAVE_SESSION']);
        $data = [ "folders" => $folders ]; 
        $this->view('contenido', $data); 
    }
   private function renameFile($param){
        $this->contenidoService->renameFile($param['chg_nombre_file_padre' ],$param[ 'chg_nombre_file_name']);
    }
    private function deleteFile($param){
        $this->contenidoService->deleteFile($param['path']);
    }
    private function renameDir($param){
        $this->contenidoService->renameDir($param['chg_nombre_dir_padre' ],$param[ 'chg_nombre_dir_name']);
    }
    private function deleteDir($param){
        $this->contenidoService->deleteDir($param['path']);
    }
    public function orderAsing(){
        if
            ((!isset($_POST['archivos']) || sizeof($_POST['archivos']) == 0 )
            || (!isset($_POST['pathContenedor']) || trim($_POST['pathContenedor']) == '' ))
            {
              http_response_code(400);
                        helper::log( 'Datos incompletos');
                    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']); 
                    return;
        }
         $this->contenidoService->reorder($_POST['pathContenedor'] , $_POST['archivos'] );
    }
}
