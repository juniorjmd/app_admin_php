<?php 
namespace Core;  
use App\Services\sessionService;
use Core\helper;
/**
 * Description of SessionManager
 *
 * @author JosédeJesúsDomínguez
 */
class SessionManager {
      private $sessionService;

   public function __construct(sessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function handleRedirections(&$url)
    {       
        if (!isset($_SESSION['LLAVE_SESSION'])) {  
            if (empty($url) || $url[0] !== 'login') {
                $url = ['login', 'index'];
            }
            return;
        } 
        if (!$this->validateSessionKey() && (isset($url[0])?$url[0]:'') !== 'login' ) { 
              $url = ['login', 'index'];
              if($_SERVER['REQUEST_METHOD'] !== 'GET') $url = ['login', 'sinAutorizacion'];
                 return;
            } 
        if (!$this->validateSessionKey() || (!empty($url) && $url[0] === 'login')) {
                $url = ['login', 'index'];
                return;
            } 

        if ($_SESSION['UsuarioActivo']->cambiar_pass  == 1) {
        // Si el usuario debe cambiar su contraseña
            if (!empty($url) && $url[0] === 'user' && isset($url[1]) && $url[1] === 'setchangePass') {
                $url = ['user', 'index'];
            } else {
                $url = ['user', 'changePass', $_SESSION['UsuarioActivo']->id  ,false];
            }
        return;
        }else{
             if (!empty($url) && $url[0] === 'user' && isset($url[1]) && $url[1] === 'changeMyPass') {
                 return;
             }
             if (!empty($url) && $url[0] === 'user' && isset($url[1]) && $url[1] === 'setchangePass') {
                 return;
             }
        }
         if (!empty($url) && $url[0] === 'contenido' && !empty($_SESSION['UsuarioActivo']->getFolder())) { 
            // print_r( $url ) ;
            return;
        } 
    

         if (empty($_SESSION['UsuarioActivo']->getPermisos())) {
        // Si el usuario no tiene permisos, redirigir a home
        $url = ['home', 'index'];
        return;
    }


    }

    private function validateSessionKey(): bool
    {
        try {
            $user = $this->sessionService->validateSessionKey($_SESSION['LLAVE_SESSION']);
            //print_r($user) ;
            if (is_null($user)) {
                return false;
            }
            $this->sessionService->getPermisosUsuario($user);
            $folders= $this->sessionService->getFolderBySessionKey($_SESSION['LLAVE_SESSION']);
             
            $user->setFolders($folders);
            $_SESSION['UsuarioActivo'] = $user;
            return true;
        } catch (\PDOException $e) {
            helper::log('Error en validateSessionKey: ' . $e->getMessage());
            return false;
        }
    }
}
