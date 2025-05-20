<?php
namespace App\Services;
use App\Repositories\FolderRepository;
use App\Models\Folder;
/**
 * Description of folderService
 *
 * @author JosédeJesúsDomínguez
 */
class folderService { 
    private $folderRepository;
    public function __construct(FolderRepository $folderRepository) {
        $this->folderRepository = $folderRepository; 
    }
    public function getAllFolder(){
        return  $this->folderRepository->read();
    }
    public function createNewFolder(Folder $folder)
    {
         try {  
            $this->folderRepository->insert_data_new_folder($folder) ; 
            echo json_encode([
                        'status' => 'success',
                        'message' => 'Datos agregados con exito' 
                    ]);
            
               
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
