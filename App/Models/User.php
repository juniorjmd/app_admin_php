<?php 
namespace App\Models; 
use App\Models\Folder;
use PDO;
class User { 
    public $id;
    public $name;
    public $user_crt;
    public $date_crt;
    public $activo;
    public $perfil;
    public $login;
    public $pass;
    public $mail; 
    public $nombrePerfil;  
    public $cambiar_pass;  
    public $numid;  
    private $folders; 
    private $permisos;
  
    public function __construct($data = []) {  
        $data['pass'] = $data['hash']?? null;
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->user_crt = $data['user_crt'] ?? null;
        $this->date_crt = $data['date_crt'] ?? null;
        $this->activo = $data['activo'] ?? null;
        $this->perfil = $data['perfil'] ?? null;
        $this->login = $data['login'] ?? null;
        $this->pass = $data['pass'] ?? null;
        $this->mail = $data['mail'] ?? null;
        $this->numid = $data['numid'] ?? null;
        $this->nombrePerfil = $data['nombrePerfil'] ?? null;
        $this->cambiar_pass = $data['cambiar_pass'] ?? null;
        $this->permisos = $data['permisos'] ?? null;
    }
   public function getPermisos(){
       return $this->permisos;
   }
    public function setPermisos( $permisos){
         $this->permisos = $permisos ;
   }
   public function setFolders($folders){
      $this->folders = $folders ;
   }
   
   public function setFolderFromArr($folder){
      $this->folders[] = Folder::fromArray($folder ) ;
   }
   
   public function getFolder() {
       return $this->folders;
   }
    
}