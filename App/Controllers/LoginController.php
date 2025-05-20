<?php
namespace App\Controllers;

use Core\Controller;  
use Core\helper;  
use App\Services\loginServices;

class LoginController extends Controller
{
    private $usuario;
    private $llave_de_session; 
    private $loginService ; 
    public function __construct(loginServices $service) { 
        $this->loginService = $service;
    }
    
    public function index()
    {
          
        switch ($_SERVER['REQUEST_METHOD']){ 
            case 'POST':
                $this->login();
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
    private function home(){
         if (isset($_SESSION['LLAVE_SESSION'])) {
            unset($_SESSION['LLAVE_SESSION']);
        }
        $data = ['title' => 'Login Page'];
        $this->view('login', $data);
    }


  
    
    
    
    
    
    public function sinAutorizacion(){
         helper::responseErrorIfTrue(true ,401 , 'Ingreso no autorizado') ; 
    }
    private function login(){ 
        try{
            $requiredParams = ['username' ,    'password'  ] ; 
            $params = helper::validateAndAssignPostParameters($requiredParams);   
            helper::responseErrorIfTrue(is_null($params) ,503 , 'Error en el servidor: Datos incompletos' ) ;  
           $username = $params['username'];
          // $password = sha1($params['password']);
           $password  = $params['password'];
           $this->llave_de_session =  sha1($username . date("Ymdhms"));
           $response = $this->loginService->loginUser($username  , $password , $this->llave_de_session ) ; 

           $idstatus = 200 ; 
           switch ($response['status'])
           {
                case 'error':
                    $idstatus = $response['message'] === 'Credenciales inválidas' ? 401 : 503 ;  
                break;
           }
           http_response_code($idstatus); 
           echo json_encode($response); 
        } catch (Exception $e) {
            helper::responseErrorIfTrue(true ,503 , 'Error en el servidor: ' . $e->getMessage()) ; 
        }
        
        
        
    }
    
    
    
    
    
  
}
