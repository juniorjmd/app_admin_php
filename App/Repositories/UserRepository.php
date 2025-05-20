<?php 
namespace App\Repositories;  
use App\Models\User;
use PDO; 
use Core\helper;
use App\Models\Folder;
use App\Models\UserMenu;
class UserRepository { 
    
    private $conn;
    private $table_name = "adm_users";

    public function __construct($db) {
        $this->conn = $db;
    }
    
         // Crear un nuevo usuario
    public function insert_data_new_user( $user ) {  
          try {
            // Conexión a la base de datos 
            $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
            $link->beginTransaction(); 
             $query = "INSERT INTO adm_users SET "
                . "name=:name, "
                . "user_crt=:user_crt, " 
                . "perfil=:perfil, "
                . "login=:login, "
                . "pass=:pass, "
                . "numid=:numid, "
                . "mail=:mail ";
               
            $consulta = $link->prepare($query);  
                $consulta->bindParam(":name", $user->name);
                $consulta->bindParam(":user_crt", $user->user_crt);
                $consulta->bindParam(":perfil", $user->perfil);
                $consulta->bindParam(":login", $user->login);
                $consulta->bindParam(":pass", $user->pass);
                $consulta->bindParam(":mail", $user->mail);
                $consulta->bindParam(":numid", $user->numid);
            if ($consulta->execute()) { 
                $link->commit();
                return  true ;
            } 
                                 else { return false ; } 
           } 
            catch (Exception $e) {  
                helper::log($e->getMessage());
                $link->rollBack();
                throw $e; 
        }
    }
    
    
    public function changeStateUser($_user , $_state){
           try {
            // Conexión a la base de datos 
            $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
            $link->beginTransaction(); 
            // Llamada al procedimiento almacenado
            $consulta = $link->prepare("update adm_users set activo =  :_estado where id =  :_usuario  ");
             
            $consulta->bindParam(':_estado', $_state);
            $consulta->bindParam(':_usuario', $_user);  
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
    public function validateRelationUserMenu($_user , $_menu , &$link){
        $sql = "SELECT COUNT(*) FROM adm_users_menu WHERE user = :user AND menu = :menu";
               $stmt = $link->prepare($sql);
               $stmt->execute(['user' => $_user, 'menu' => $_menu]);
               $exists = $stmt->fetchColumn(); 
    }
    public function changeRelationUserMenu($_user , $_menu, $_state){
           try {
            // Conexión a la base de datos 
            $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
            $link->beginTransaction(); 
            // Llamada al procedimiento almacenado
            $query = '';
            if ($_state == 1 ){ 
               $exists = $this->validateRelationUserMenu($_user , $_menu ,$link); 
               if($exists > 0) {
                throw new Exception("Ya existe una relación entre el usuario $_user y el menú $_menu");
               } 
                $query = "insert into adm_users_menu (  user, menu  ) values "
                        . "( :_usuario  , :_menu )";
            }else{
                $query = "delete from adm_users_menu where  user = :_usuario and  menu = :_menu   ";
            }
            $consulta = $link->prepare($query); 
            $consulta->bindParam(':_menu', $_menu);
            $consulta->bindParam(':_usuario', $_user);  
            if ($consulta->execute()) { 
                $link->commit(); return  true ; } 
                                 else { return false ; } 
           } 
            catch (Exception $e) {
                 helper::log( $e->getMessage());
                $link->rollBack();
                throw $e; 
        }
        
    }
  
        public function changePasswordUser($_user ){
           try {
            // Conexión a la base de datos 
            $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
            $link->beginTransaction(); 
            // Llamada al procedimiento almacenado
            $consulta = $link->prepare("update adm_users set pass =  :_pass  ,  cambiar_pass = :_cambiar_pass where id =  :_usuario  ");
            $consulta->bindParam(':_pass', $_user->pass );
            $_user->cambiar_pass = ($_user->cambiar_pass == '')? 0 : $_user->cambiar_pass ; 
            $consulta->bindParam(':_cambiar_pass',$_user->cambiar_pass );
            $consulta->bindParam(':_usuario', $_user->id );  
           
            if ($consulta->execute()) {
                $link->commit(); return  true ; } 
                                 else { return false ; } 
           } 
            catch (Exception $e) {
                helper::log( $e->getMessage());
                $link->rollBack();
                throw $e; 
        }
        
    }
  
    // Leer todos los usuarios
    public function read() {
        $query = "SELECT * FROM vw_" . $this->table_name;
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query);
        $stmt->execute();
        $array =  $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->closeCursor();
        $users = [];
        foreach ($array as $row) {
             $users[] = new User($row);
        }
    return $users;  
        
        }
   public function readFolders() {
        $query = "SELECT * FROM adm_menus" ;
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query);
        $stmt->execute();
        $array =  $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->closeCursor();
        $folders = [];
        foreach ($array as $row) {
             $folders[] = Folder::fromArray($row);
        }
    return $folders;  
        
        }

    // Leer un solo usuario por ID
    public function readByNumId( $id ) {
        $query = "SELECT * FROM vw_" . $this->table_name . " WHERE numid = ? LIMIT 0,1";

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
    
    
     public function readFolderById( $id ) {
        $query = "SELECT * FROM vw_adm_users_menu WHERE user = ? "; 
        $link = $this->conn->getLink();
        $stmt = $link->prepare($query); 
        $stmt->bindParam(1, $id);
        $stmt->execute();  
        $array =  $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $userFolders = [];
        foreach ($array as $row) {
             $userFolders[] = UserMenu::fromArray($row);
        }
    return $userFolders;  
    }

    // Actualizar un usuario
    public function update($user) {
     try {  
        $query = "UPDATE " . $this->table_name . " SET name = :name, "
                . " perfil = :perfil, login = :login, "
                . " mail = :mail WHERE id = :id";
        $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
        $link->beginTransaction(); 
            // Llamada al procedimiento almacenado 
        $consulta =  $link->prepare($query); 
        $consulta->bindParam(":name", $user->name);  
        $consulta->bindParam(":perfil", $user->perfil);
        $consulta->bindParam(":login", $user->login); 
        $consulta->bindParam(":mail", $user->mail);
        $consulta->bindParam(":id", $user->id);  
         if ($consulta->execute()) { 
              $link->commit();
              return  true ; 
         }else { $link->rollBack(); return false ; } 
            
        } catch (Exception $e) { 
            helper::log( $e->getMessage());
            $link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    }
 
    
    
    public function authenticate($_usuario, $_password ,$_llave)
    {
        try {  
            $link = $this->conn->getLink(); 
            // Usamos transacción si es necesario
            $link->beginTransaction(); 
            // Llamada al procedimiento almacenado
            $consulta = $link->prepare("CALL sp_login(:_usuario, :_pass, :_llave)");
            
            //echo "CALL sp_login(:$_usuario, :$_password, :$_llave)";
            $consulta->bindParam(':_usuario', $_usuario);
            $consulta->bindParam(':_pass', $_password);
            $consulta->bindParam(':_llave', $_llave);
            $consulta->execute(); 
            // Recibimos el resultado de la respuesta del procedimiento
            $array = $consulta->fetchAll(PDO::FETCH_ASSOC); 
            $consulta->closeCursor();   
            $response = json_decode($array[0]['procedure_response'], true);  
            if ($response['error'] === 'ok') {
                // Commit de la transacción si todo fue bien
                $link->commit(); 
                return true;
            } else {
                // Rollback en caso de error
                $link->rollBack();
                return false;
            }
        } catch (Exception $e) {
            helper::log( $e->getMessage());
            $link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    } 
    
    
    public function getUserPermisosById($_llave)
    {
        try {   
            $link = $this->conn->getLink();  
            $consulta = $link->prepare("CALL sp_get_permisos_by_user_id( :_llave)"); 
           // ECHO "CALL sp_get_user_by_key_session('$_llave' )";
            $consulta->bindParam(':_llave', $_llave);
            $consulta->execute();  
            $array = $consulta->fetchAll(PDO::FETCH_ASSOC); 
            $consulta->closeCursor(); 
          if (sizeof($array) == 1 && isset($array[0]['procedure_response'])){
                $response = json_decode($array[0]['procedure_response'], true);  
                throw new \Exception($response);
            }else{
              return    $array ;
                }
        } catch (Exception $e) {
            helper::log( $e->getMessage());
            //$link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    }
    public function getUserByNumberID($_llave)
    {
        try {   
            $link = $this->conn->getLink();  
            $consulta = $link->prepare("CALL sp_get_user_by_num_id( :_llave)"); 
             //ECHO "CALL sp_get_user_by_num_id('$_llave' )";
            $consulta->bindParam(':_llave', $_llave);
            $consulta->execute();  
            $array = $consulta->fetchAll(PDO::FETCH_ASSOC); 
            $consulta->closeCursor();   
            $response = json_decode($array[0]['procedure_response'], true);   
            //print_r($response);
            if ($response['error'] === 'ok') { 
                return  new User($response['user']); 
            } elseif ($response['code'] === 1) { 
                return null;
                } else { 
                    throw new \Exception($response);
                } 
        } catch (Exception $e) {
            helper::log( $e->getMessage());
            //$link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    }
     public function getUserBySessionKey($_llave)
    {
        try {   
            $link = $this->conn->getLink();  
            $consulta = $link->prepare("CALL sp_get_user_by_key_session( :_llave)"); 
            // ECHO "CALL sp_get_user_by_key_session('$_llave' )";
            $consulta->bindParam(':_llave', $_llave);
            $consulta->execute();  
            $array = $consulta->fetchAll(PDO::FETCH_ASSOC); 
            $consulta->closeCursor();   
            $response = json_decode($array[0]['procedure_response'], true);   
            //print_r($response);
            if ($response['error'] === 'ok') { 
                return  new User($response['user']); 
            } elseif ($response['code'] === 1) { 
                return null;
                } else { 
                    throw new \Exception($response);
                } 
        } catch (Exception $e) {
            helper::log( $e->getMessage());
            //$link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    }
    public function getUserFoldersBySessionKey($_llave)
    {
        try {   
            $link = $this->conn->getLink();  
            $query =  "SELECT adm_menus.* FROM  adm_menus inner join adm_users_menu on adm_users_menu.menu = adm_menus.id ".
                      "inner join adm_session on adm_users_menu.user = adm_session.usuario and activo = true "
                    . "and adm_session.key  = :_llave ;";
            $consulta = $link->prepare($query); 
            $consulta->bindParam(':_llave', $_llave);
            $consulta->execute();  
            $array = $consulta->fetchAll(PDO::FETCH_ASSOC); 
            $consulta->closeCursor();     
            $folders = [];
            foreach ($array as $row) {
                 $folders[] = Folder::fromArray($row);
            }
            return $folders;   
        } catch (Exception $e) {
            helper::log( $e->getMessage());
            //$link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    }
    
    
    public function getFolderBySessionKey($_llave , $_id_folder)
    {
        try {   
            $link = $this->conn->getLink();  
            $query =  "SELECT adm_menus.* FROM  adm_menus inner join adm_users_menu on adm_users_menu.menu = adm_menus.id ".
                      "inner join adm_session on adm_users_menu.user = adm_session.usuario and activo = true "
                    . "and adm_session.key  = :_llave  and adm_menus.id = :id_folder ;";
            $consulta = $link->prepare($query); 
            $consulta->bindParam(':_llave', $_llave);
            $consulta->bindParam(':id_folder', $_id_folder);
            $consulta->execute(); 
            $row = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor(); 
                if ($row) {
                    return Folder::fromArray($row);
                } 
            return null;   
        } catch (Exception $e) {
            helper::log( $e->getMessage());
            //$link->rollBack();
            throw $e; // Relanzamos la excepción para manejarla en el login
        }
    }
}
