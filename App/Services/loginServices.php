<?php 
namespace App\Services;
use App\Repositories\UserRepository; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Core\helper;

/**
 * Description of loginServices
 *
 * @author JosédeJesúsDomínguez
 */
class loginServices { 
    private $userRepository ; 
    private $origenLogin;
    public function __construct(UserRepository $userRepository ) {
        $this->userRepository = $userRepository ; 
    }
    private function loginUser_old($username , $password , $llave_de_session ) 
          {  
            try { 
                if($this->userRepository->authenticate( $username, $password , $llave_de_session)) { 
                    
                    $_SESSION['LLAVE_SESSION'] = $llave_de_session ;  
                     return[ 
                        'status' => 'success',
                        'message' => 'Login exitoso'  ,
                        'session_key' => $llave_de_session] ;
                     $this->sendLog('Login exitoso');
                } else {
                    // Si las credenciales son incorrectas, se debe retornar un 401 (Unauthorized)
                     return ['status' => 'error', 'message' => 'Credenciales inválidas' ] ;
                }
            } catch (\Throwable $e) {
                // Capturamos las excepciones de conexión y otros errores relacionados con la base de datos
                return['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()] ;
            }
       
    }
    
    //private function loginLdap(&$username , &$password ){ 
    public function loginUser($username , $password , $llave_de_session ) {
        $ch =  $this->getCurlConn(); 
        $response = $this->connetLdapLogin($username  , $password, $ch );
         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $responseData = json_decode($response, true);
        if ($responseData === null && json_last_error() !== JSON_ERROR_NONE) { 
           return ['status' => 'error', 'message' => 'Error al decodificar la respuesta JSON' ] ;
        } 
        if (!is_array($responseData)) {
            return ['status' => 'error', 'message' => 'Error en la respuesta del sbs' ] ;
        } 
        switch ($httpCode) {
            case 200: 
                 if($responseData['exists'] === false){
                    $this->origenLogin = 'Usuario No existe en el LDAP =>';
                    $password = sha1($password);
                    return $this->loginUser_old($username , $password , $llave_de_session );
                }else{
                    if($responseData['auth'] === true){
                        return $this->workWithJWTLogin($responseData['JWT'], $llave_de_session  );
                    }
                     return ['status' => 'error', 'message' => 'Credenciales inválidas' ] ;
                } 
             break;
            default:
                 return ['status' => 'error', 'message' => 'Credenciales inválidas' ] ;
             break;
        }
    }
    private function workWithJWTLogin($token, $llave_de_session ){ 
        $usr = $this->getInfoJWT($token); 
        $usr_db = $this->getUsrByNumberId($usr->extensionattribute4 ); 
        if(is_null($usr_db)){
            $this->origenLogin = 'Usuario existe en el LDAP => ';
            $this->sendLog('Credenciales inválidas NO TIENE USUARIO ACTIVO EN EL SISTEMA DE AUTOGESTION');
            return ['status' => 'error', 'message' => 'Credenciales inválidas' ] ;
        }
        $this->origenLogin = 'Usuario existe en el LDAP =>';
        return $this->loginUser_old($usr_db->login , $usr_db->pass , $llave_de_session );  
    }
    private function sendLog($msg){
           helper::log( (($this->origenLogin != '' )?$this->origenLogin ." " : '' ) . $msg);
    }
    private function getUsrByNumberId($numberId){
        return $this->userRepository->getUserByNumberID($numberId);
    }
    private function getInfoJWT($token){ 
        return   JWT::decode($token, new Key(KEY_RESP_SBS, 'HS256'));
    }
    private function getCurlConn(){ 
        $url = SBS_HOME;
        return curl_init($url); 
    } 
            
    private function connetLdapLogin($usrlogin ,$pass , &$ch ){
        $tokenBearer = ID_APP_SBS; 
        $data = [
            "appkey" => APY_KEY_SBS,
            "usrlogin" => $usrlogin ,
            "pass" => $pass
        ]; 
        $jsonData = json_encode($data); 
          
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);        // Indica que es una petición POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Envía los datos JSON en el cuerpo
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $tokenBearer // Envía el token Bearer en la cabecera
        ]);   
         if (curl_errno($ch)) {
            $error = curl_error($ch);
            helper::log('Error al consumir el servicio : ' . $error);
            throw new \Exception('Error al consumir el servicio : ' . $error);  
         }
            
        return   curl_exec($ch);
    }
}
