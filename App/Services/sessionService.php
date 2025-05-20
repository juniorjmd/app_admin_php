<?php 
namespace App\Services;  
use App\Models\User;
class sessionService { 
    private $userRepository ; 
    
    public function __construct($userRepository) {
        $this->userRepository = $userRepository;
    }
    public function validateSessionKey($session_key){
         return $this->userRepository->getUserBySessionKey($session_key);
    }
    
    public function getPermisosUsuario(User &$_user){
         $permisos =   $this->userRepository->getUserPermisosById($_user->id);
         if($permisos) $_user->setPermisos ($permisos);
    
    }
     public function getFolderBySessionKey($session_key){
         return $this->userRepository->getUserFoldersBySessionKey($session_key);
    } 
    
}
