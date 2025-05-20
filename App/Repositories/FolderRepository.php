<?php 
namespace App\Repositories; 
use App\Models\Folder;
use PDO;
use Core\helper;
use Core\DataBase;
class FolderRepository { 
    
    private $conn;
    private $table_name = "adm_menus";

    public function __construct($db) {
        $this->conn = $db;
    }
    
         // Crear un nuevo usuario 
    public function insert_data_new_folder($menu) {  
    $link = $this->conn->getLink();  
   
    try { 
        $link->beginTransaction(); 
        $this->createFolder($menu); // Crear carpeta física 
        $menuId = $this->insertMenu($menu , $link); // Insertar menú en DB 
        $this->createWordPressPage($menuId); // Crear página en WordPress 
        $link->commit();
        return $menuId;
    } catch (\Exception $e) {
        helper::log($e->getMessage());
        $this->removeFolderOnError($menu, $link); 
        throw $e;
    }
}
    private function insertMenu($menu , $link) {
     $query = "INSERT INTO adm_menus SET " 
                . "name=:name, "
                . "description=:description, "
                . "display_name=:display_name, "
                . "user=:user, "
                . "ruta_fisica=:ruta_fisica";
    
    $stmt = $link->prepare($query);
    $stmt->bindParam(":ruta_fisica", $menu->ruta_fisica);
    $stmt->bindParam(":name", $menu->name);
    $stmt->bindParam(":description", $menu->description);
    $stmt->bindParam(":display_name", $menu->display_name);
    $stmt->bindParam(":user", $menu->user);
    
    if (!$stmt->execute()) {
        throw new \Exception("Error al insertar el menú en la base de datos.");
    }
    return $link->lastInsertId();
}

    public function getMenuById($menuId)
    {
    try {
        $query = "SELECT * FROM adm_menus WHERE id = :id";
        $consulta = $this->conn->getLink()->prepare($query);
        $consulta->bindParam(":id", $menuId);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        helper::log($e->getMessage());
        return false;
    }
}   
    public function createWordPressPage($menuId)
    { 
        try { 
            $menu = $this->getMenuById($menuId); 
            $data = [
            'title' => ucfirst($menu['display_name']), // Título de la página
            'content' =>  $menu['description'] . '<br><br>'.'[shortcode_carpeta contenido_carpeta="' . $menu['name']  . '"]', // Contenido dinámico
            'status' => 'publish', // Estado de la página
        ];
            $folderName = $menu['display_name'];
            
            $result = $this->conectToWPRestCrt($data); 
        // Verificar si hubo un error
        if ($result === false || is_null($result)) {
            helper::log("Error al crear página en WordPress para la carpeta: $folderName");
             throw new \Exception("Error al crear página en WordPress para la carpeta: $folderName");
        } 

             $data = json_decode($result, true); // Cambia a `false` para un objeto en lugar de un array  
             //print_r($data);
            return $this->changeWordPressId($menuId ,$data['id'] );
     }
     catch (Exception $e) {
        helper::log($e->getMessage());  
        throw $e; 
    }
} 
    private function conectToWPRestCrt($data) { 
    $authToken = trim(SESSION_WP); // Eliminar espacios
    $userWp = SESSION_NAME_WP;
    $auth = base64_encode("$userWp:$authToken"); // Eliminar espacios adicionales

    $ch = curl_init(REST_API_WP_CREATE);
    
    $headers = [
        "Content-Type: application/json",
        "Authorization: Basic $auth"
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ⚠️ Desactiva SSL temporalmente
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        helper::log("Error en cURL: " . $error);
        curl_close($ch);
        throw new Exception("Error al conectar con la API de WordPress: " . $error);
    }

    curl_close($ch);
    return  $response ;
}
 
    
    private function conectToWPRestDlt($pageId) {
    $authToken = str_replace(' ', '', SESSION_WP);
    $userWp = SESSION_NAME_WP;
    $auth = base64_encode("$userWp:$authToken"); 

    // Construcción de la URL
    $url = str_replace('$PAGEID$', $pageId, REST_API_WP_DELETE);

    // Inicializar cURL
    $ch = curl_init();

    // Configuración de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Método DELETE
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic $auth"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir respuesta como string 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ⚠️ Desactiva SSL temporalmente
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Tiempo máximo de espera de 30 segundos

    // Ejecutar la solicitud
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Manejo de errores
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        helper::log("Error en cURL: " . $error);
        curl_close($ch);
        throw new Exception("Error al conectar con la API de WordPress: " . $error);
    }

    // Cerrar conexión cURL
    curl_close($ch);

    // Verificar si la API respondió con un error HTTP
    if ($httpCode < 200 || $httpCode >= 300) {
        helper::log("Error HTTP $httpCode al eliminar página $pageId en WordPress.");
        throw new Exception("Error HTTP $httpCode al eliminar página en WordPress.");
    }

    // Devolver la respuesta de la API (sin modificar, igual que con file_get_contents)
    return $result;
}

    
    private function deleteWordPressPage($menuId) {
    try {
        $menu = $this->getMenuById($menuId);
        if (!$menu || !isset($menu['id_wp']) || empty($menu['id_wp'])) {
            throw new \Exception("No se encontró una página asociada en WordPress para este menú.");
        } 
        $result = $this->conectToWPRestDlt($menu['id_wp']);  
        if ($result === false) {
            throw new \Exception("Error al eliminar la página de WordPress.");
        } 
        helper::log("Página de WordPress con ID {$menu['id_wp']} eliminada exitosamente.");
        return true;
    } catch (\Exception $e) {
        helper::log("Error al eliminar la página de WordPress: " . $e->getMessage());
        throw $e;
    }
}
    private function renameFolder($menuId) {
    try {
            // Obtener el menú para acceder a la ruta física
            $menu = $this->getMenuById($menuId); 
            //print_r($menuId);
            if (!$menu || !isset($menu['ruta_fisica']) || empty($menu['ruta_fisica'])) {
                helper::log("Error al renombrar la carpeta: No se encontró una carpeta asociada al menú.");
                throw new \Exception("No se encontró una carpeta asociada al menú.");
            } 
            $rutaActual = $menu['ruta_fisica'];
            if (!is_dir($rutaActual)) {
                helper::log("La carpeta no existe: $rutaActual");
                return false;
            }  
            $nuevaRuta = $rutaActual .  date('dmy');

            // Renombrar la carpeta
            if (!rename($rutaActual, $nuevaRuta)) {
                throw new \Exception("Error al renombrar la carpeta: $rutaActual");
            }

            helper::log("Carpeta renombrada de $rutaActual a $nuevaRuta");
            return true;
        } catch (\Exception $e) {
            helper::log("Error al renombrar la carpeta: " . $e->getMessage());
            throw $e;
        }
    } 
    public function deleteMenuAndPage($menuId) {
        $link = $this->conn->getLink();
        try {
            $link->beginTransaction();
            $this->renameFolder($menuId);
            // Eliminar la página de WordPress
            $this->deleteWordPressPage($menuId);

            // Eliminar el registro del menú en la base de datos
            $query = "DELETE FROM adm_menus WHERE id = :id";
            $stmt = $link->prepare($query);
            $stmt->bindParam(":id", $menuId);

            if (!$stmt->execute()) {
                throw new \Exception("Error al eliminar el menú de la base de datos.");
            }

            $link->commit();
            return true;
        } catch (\Exception $e) {
            if ($link->inTransaction()) {
                $link->rollBack();
            }
            helper::log("Error al eliminar el menú y la página de WordPress: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function removeDir($path) {
         if ( is_dir($path)) {
            rmdir($path);
            return true;
        }
        return false;
    }
    public function renameDir($path , $newPath) {
         if ( is_dir($path)) {
             rename($path ,$newPath );
            return true;
        }
        return false;
    }
        public function renameFile($path , $newPath) {
         if ( !is_dir($path)) {
             rename($path ,$newPath );
            return true;
        }
        return false;
    }
          
public function reorderItems($reorderPath ,$files ){
    foreach ($files as   $file) {
        $file_path = (isset($file['name']))? DOCUMENT_ROOT."/admin/public/". $file['name'] : '' ;
        if($file_path != ''){ 
        $file_n_path = $reorderPath."/".$file['newName'];
            if ($file_path != $file_n_path && file_exists($file_path) ){ 
                if(!rename($file_path ,$file_n_path )) {
                   return false; 
                }
            }
        }
    }
    return true;
}
public function deleteFolderRecursively($folderPath)
{
    // Obtener el contenido de la carpeta
    $files = array_diff(scandir($folderPath), ['.', '..']);

    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

        if (is_dir($filePath)) {
            // Si es una carpeta, eliminarla recursivamente
            $this->deleteFolderRecursively($filePath);
        } else {
            // Si es un archivo, eliminarlo
            if (!unlink($filePath)) {
                throw new \Exception("No se pudo eliminar el archivo: $filePath");
            }
        }
    }

    // Eliminar la carpeta vacía
    if (!rmdir($folderPath)) {
        throw new \Exception("No se pudo eliminar la carpeta: $folderPath");
    }
}


    private function removeFolderOnError($menu, $link) {
        if (isset($menu->ruta_fisica) && is_dir($menu->ruta_fisica)) {
            rmdir($menu->ruta_fisica);
        }
        if ($link->inTransaction()) {
            $link->rollBack();
    }}

    private function changeWordPressId($_id_menu, $_id_wp){
           try {
            // Conexión a la base de datos 
            $link = $this->conn->getLink();  
            // Llamada al procedimiento almacenado
            $consulta = $link->prepare("update adm_menus set id_wp =  :_id_wp where id =  :_id_menu  ");
             
            $consulta->bindParam(':_id_menu', $_id_menu); 
            $consulta->bindParam(':_id_wp', $_id_wp); 
            $consulta->execute();  
            if ($consulta->execute()) { return  true ; } 
                                 else { return false ; } 
           } 
            catch (Exception $e) { 
                helper::log($e->getMessage());  
                $link->rollBack();
                throw $e; 
        }
        
    }
  
    private function createFolder(&$menu){
         $ruta_base = realpath('uploads') . DIRECTORY_SEPARATOR; // Obtiene la ruta absoluta de 'uploads'
        $nombre_carpeta = basename($menu->name); // Solo permite el nombre de la carpeta, sin rutas relativas

        $ruta_carpeta = $ruta_base . $nombre_carpeta;
        // Validar que no haya intentos de salir de 'uploads'
        
        //helper::log("Nombre de carpeta {$ruta_carpeta}");
        if(file_exists($ruta_carpeta)){
            throw new \Exception("la carpeta que intenta crear ya existe!");
        } 
       if( !mkdir($ruta_carpeta,  0777, true)){
           throw new \Exception("Error al crear la carpeta."); 
       }
       $menu->ruta_fisica = $ruta_carpeta ;  
    }
    // Leer todos los usuarios
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query);
        $stmt->execute();
        $array =  $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->closeCursor();
        $folders = [];
        foreach ($array as $row) {
             $folders[] =  Folder::fromArray($row);
        }
    return $folders;  
        
        }

    // Leer un solo usuario por ID
    public function readById( $id ) {
        $query = "SELECT * FROM vw_" . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $link = $this->conn->getLink();
        $stmt = $link->prepare($query); 
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row);
        }

        return null;
    }

    // Actualizar un usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, user_crt = :user_crt, date_crt = :date_crt, activo = :activo, perfil = :perfil, login = :login, pass = :pass, mail = :mail WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->user_crt=htmlspecialchars(strip_tags($this->user_crt));
        $this->date_crt=htmlspecialchars(strip_tags($this->date_crt));
        $this->activo=htmlspecialchars(strip_tags($this->activo));
        $this->perfil=htmlspecialchars(strip_tags($this->perfil));
        $this->login=htmlspecialchars(strip_tags($this->login));
        $this->pass=htmlspecialchars(strip_tags($this->pass));
        $this->mail=htmlspecialchars(strip_tags($this->mail));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":user_crt", $this->user_crt);
        $stmt->bindParam(":date_crt", $this->date_crt);
        $stmt->bindParam(":activo", $this->activo);
        $stmt->bindParam(":perfil", $this->perfil);
        $stmt->bindParam(":login", $this->login);
        $stmt->bindParam(":pass", $this->pass);
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
 private  function transformarNombreArchivo($nombre) {
    $nombre = preg_replace("/^\d+_fin_/", "", $nombre);

    // Elimina la extensión del archivo
    $nombre = pathinfo($nombre, PATHINFO_FILENAME);

    // Reemplaza caracteres especiales con espacios
    $nombre = preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9]/u", " ", $nombre);

    // Convierte la primera letra de cada palabra en mayúscula
    $nombre = mb_convert_case($nombre, MB_CASE_TITLE, "UTF-8");

    // Elimina espacios adicionales
    $nombre = preg_replace("/\s+/", " ", $nombre);

    return trim($nombre);
}

 
private function generarListaCarpetas($pathDown ,$ruta , $raiz , $id = ''  ){
    $contador = 1 ; 
     $archivos = scandir($ruta);  
     $_id = ($id != '' )? ' id = "$id" '  :'';
        $salida  = "<ul   {$_id}  class= 'list-group sort-element list-group-flush' data-aos='fade-right'>" ;
        if(is_array($archivos) && sizeof($archivos) > 2 ){ 
        usort($archivos, function($a, $b) {
            preg_match('/^\d+/', $a, $matchesA);
            preg_match('/^\d+/', $b, $matchesB);

            $numeroA = isset($matchesA[0]) ? (int)$matchesA[0] : 0;
            $numeroB = isset($matchesB[0]) ? (int)$matchesB[0] : 0;

            return $numeroA <=> $numeroB;
        });

         foreach ($archivos as $archivo) {
            if ($archivo !== '.' && $archivo !== '..') {
                // Añadir cada archivo como un elemento de lista
                $archivoUrl = $pathDown.'/'.$archivo ; 
                $archivoRuta =  $ruta . DIRECTORY_SEPARATOR . $archivo; 
                $nombreCarpeta = $raiz.'/'.$archivo;  
                $nombreOriginal = $archivo;
                $nombreSinOrden =  preg_replace("/^\d+_fin_/", "", $nombreOriginal);
                $archivo = $this->transformarNombreArchivo($archivo); 
                 if (is_dir($archivoRuta)){
                     $salida .= '<li class="list-group-item" >'
                             . '<i class="fas fa-folder text-warning me-2"></i> &nbsp; &nbsp;'
                             . htmlspecialchars($archivo)
                             .'<input id="paht_orden" type="hidden" value="'.$contador.'" />' 
                             .'<input id="nombre_sin_orden" type="hidden" value="'.$nombreSinOrden.'" />' 
                             .'<input id="paht_input" type="hidden" value="'.$nombreCarpeta.'" />' 
                             .'&nbsp; &nbsp;<i class="fa-solid fa-upload upload_file" data-path></i>' 
                             . '&nbsp; &nbsp;<i class="fas fa-folder-plus create_folder"  ></i>' 
                             . '&nbsp; &nbsp;<i class="fas fa-edit rename_dir" data-real = "'.$nombreOriginal.'"  ></i>'
                        . '&nbsp; &nbsp;<i class="fa-solid fa-trash delete_dir"  ></i>'
                             .  $this->generarListaCarpetas($archivoUrl ,$archivoRuta , $nombreCarpeta,''  ) 
                             
                             .'</li>';
                 }else{
                $salida .= '<li class="list-group-item" >'   
                        . '<i class="fas fa-tint gota"></i> '
                        . '&nbsp; &nbsp;'
                        .   htmlspecialchars($archivo)  
                        .'<input id="nombre_sin_orden" type="hidden" value="'.$nombreSinOrden.'" />' 
                        .'<input id="paht_orden" type="hidden" value="'.$contador.'" />' 
                        . '<input id="paht_input" type="hidden" value="'.$nombreCarpeta.'" />' 
                        . '&nbsp; &nbsp;<i class="fa-solid fa-trash delete_file"  ></i>'
                        . '&nbsp; &nbsp;<i class="fas fa-edit rename_file" data-real = "'.$nombreOriginal.'"  ></i>'
                        . '</li>';
            }
            $contador++;
                 }
        }
         }else{
              $salida .= '<li class="list-group-item" ></li>';
        }
        $salida .= '</ul>';
        return $salida;
}
function mostrar_contenido_carpeta($nombreCarpeta) {   
    $basePath = DOCUMENT_ROOT. '/admin/public/';
    $pathDown =  '../admin/public/'.$nombreCarpeta;
    $ruta = realpath($basePath . $nombreCarpeta);
    $salida = '';
    if (is_dir($ruta)) {
              $salida = "<ul class= 'list-group list-group-flush' id='listado_carpeta' data-aos='fade-right'>"
                        .'<li class="list-group-item " >'
                        . '<i class="fas fa-folder text-warning me-2"></i> &nbsp; &nbsp;'
                        . htmlspecialchars($nombreCarpeta)
                        . '<input id="paht_input" type="hidden" value="'.$nombreCarpeta.'" />' 
                        . '&nbsp; &nbsp;<i class="fa-solid fa-upload upload_file" data-path="'.$nombreCarpeta.'"></i>'
                        . '&nbsp; &nbsp;<i class="fas fa-folder-plus create_folder"  data-path="'.$nombreCarpeta.'"></i>'
                        . $this->generarListaCarpetas($pathDown ,$ruta , $nombreCarpeta, 'sortable'  )  
                      . '</li></ul>';
         
        return $salida;
    } else {
        // Mensaje si la carpeta no existe
        return '<p>La carpeta "' . htmlspecialchars($nombreCarpeta) . '" no existe.</p>';
    }
}
public function deleteFile($path){
    if(unlink($path)){
        return true;
    }
    return false;
}
public function createDir($path){
    if(mkdir($path)){
        return true;
    }
    return false;
}

}
