<?php
namespace App\Services;
use App\Repositories\FolderRepository;
use App\Models\Folder;
use App\Repositories\UserRepository;
/**
 * Description of folderService
 *
 * @author JosédeJesúsDomínguez
 */
class contenidoService { 
    private $folderRepository;
    private $userRepository;
    public function __construct( UserRepository $userRepository ,  FolderRepository $folderRepository) {
        $this->folderRepository = $folderRepository; 
        $this->userRepository = $userRepository; 
    }
    public function createDir( $dir_container , $new_dir){
         $containerPath = DOCUMENT_ROOT."/admin/public/$dir_container";
        $new_dir = basename($new_dir);
         try { 
             if (!file_exists($containerPath)) {
                    throw new \Exception("La ruta especificada no existe: $containerPath");
                }

            if (!is_dir($containerPath)) {
                throw new \Exception("La ruta especificada no es una carpeta: $containerPath");
            }
            if (file_exists("$dir_container/$new_dir")) {
                    throw new \Exception("El directorio especificado ya existe: $dir_container/$new_dir");
                }
            
            if ($this->folderRepository->createDir("$dir_container/$new_dir")) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'directorio creado con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al crear el nuevo directorio']);
                }
               
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    
    public function renameDir( $path , $newName  ) {
         $renamePath = DOCUMENT_ROOT."/admin/public/$path"; 
         $newName = basename($newName);
         $newPath = dirname($renamePath) .'/'.$newName ;
         
        // die($newPath);
         try { 
             
            if (file_exists($newPath)) {
                    throw new \Exception("Ya existe un directorio con ese nombre: $renamePath", 404);
                } 
            
            if (!file_exists($renamePath)) {
                    throw new \Exception("La ruta especificada no existe: $renamePath", 404);
                } 
            if (!is_dir($renamePath)) {
                    throw new \Exception("La ruta especificada no es un directorio: $renamePath", 400);
                }
             if (!$this->folderRepository->renameDir($renamePath, $newPath)) {
            throw new \Exception("Error al renombrar el directorio", 500);
            }
           http_response_code(200); // OK
            echo json_encode([
            'status' => 'success',
            'message' => 'Directorio renombrado con éxito',
            ]);
               
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    public function deleteDir( $path) {
        //$PRUEBA = $path;
        //$path = basename($path);
         $deletePath = DOCUMENT_ROOT."/admin/public/$path";
         try { 
            if (!file_exists($deletePath)) {
                    throw new \Exception("La ruta especificada no existe: $deletePath - - $PRUEBA", 404);
                } 
            if (!is_dir($deletePath)) {
                    throw new \Exception("La ruta especificada no es un directorio: $deletePath", 400);
                }
            $this->folderRepository->deleteFolderRecursively($deletePath) ;
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos eliminados con exito' 
                    ]);
               
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    
    public function reorder( $path , $files) {
         $reorderPath = DOCUMENT_ROOT."/admin/public/$path";
         try { 
            if (!file_exists($reorderPath)) {
                    throw new \Exception("La ruta especificada no existe: $reorderPath", 404);
                } 
            if (!is_dir($reorderPath)) {
                    throw new \Exception("La ruta especificada no es un directorio: $reorderPath", 400);
                }
            $this->folderRepository->reorderItems($reorderPath ,$files ) ;
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos eliminados con exito' 
                    ]);
               
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    
    public function renameFile( $path , $newName  ) {
         $renamePath = DOCUMENT_ROOT."/admin/public/$path";     
         $fileInfo = pathinfo($renamePath);
         $fileExtension = isset($fileInfo['extension']) ? $fileInfo['extension'] : '';
         $newPath = dirname($renamePath) .'/'.$newName . '.'. $fileExtension ;
         
        // die($newPath);
         try { 
             
             if ($fileExtension == '') {
                    throw new \Exception("error al obtener la extencion del archivo : $renamePath", 404);
                }  
            if (file_exists($newPath)) {
                    throw new \Exception("Ya existe un archivo con ese nombre: $renamePath", 404);
                } 
            
            if (!file_exists($renamePath)) {
                    throw new \Exception("La ruta especificada no existe: $renamePath", 404);
                } 
            if (is_dir($renamePath)) {
                    throw new \Exception("La ruta especificada no es un archivo: $renamePath", 400);
                }
             if (!$this->folderRepository->renameFile($renamePath, $newPath)) {
            throw new \Exception("Error al renombrar el archivo", 500);
            }
           http_response_code(200); // OK
            echo json_encode([
            'status' => 'success',
            'message' => 'Archivo renombrado con éxito',
            ]);
               
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    public function deleteFile($path){
        //uploads/gestion_humana/cargue 1/DICCIONARIO DE COMPETENCIAS (3).pdf
        $deletePath = DOCUMENT_ROOT."/admin/public/$path";
       
         try { 
            if (file_exists($deletePath)) {  
                if ($this->folderRepository->deleteFile($deletePath)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos eliminados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el archivo']);
                }
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error el elemento a eliminar no existe!']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    
    public function getContenidoFolder(Folder $folder){
        return $this->folderRepository->mostrar_contenido_carpeta($folder->ruta_fisica);
    }
    public function getFolderBySessionKey($session_key){
         return $this->userRepository->getUserFoldersBySessionKey($session_key);
    } 
     public function validateFolderBySessionKey($session_key  , $folderId){
         return $this->userRepository->getFolderBySessionKey($session_key , $folderId);
    }
    public function getAllFolder(){
        return  $this->folderRepository->read();
    }
    public function createNewFolder(Folder $folder)
    {
         try { 
            if ($this->folderRepository->insert_data_new_folder($folder)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos agregados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al crear nueva carpeta']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
     public function deleteFolder( $id_folder)
    {
         try { 
            if ($this->folderRepository->deleteMenuAndPage($id_folder)) {  
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos eliminados con exito' 
                    ]);
                } else { 
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar carpeta']);
                }
        } catch (\Throwable $e) { 
            http_response_code(503); // Service unavailable
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
    
   
}
