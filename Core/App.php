<?php 
namespace Core;  
class App
{  
    private $router;
    private $sessionManager;
    public function __construct(Router $router, SessionManager $sessionManager)
    {  
        $this->router = $router;
        $this->sessionManager = $sessionManager; 
        $url = $this->router->parseUrl();  
        $this->sessionManager->handleRedirections($url);  
        $controllerName = $this->router->getController($url); 
        $controller = $this->createController($controllerName);  
        
        $methodName = $this->router->getMethod($url, $controller);
        
        $params = $this->router->getParams($url); 
       
        
        call_user_func_array([$controller, $methodName], $params);
    } 
     private function createController(string $controllerName)
    {
        // echo $controllerName;
        // Mapear controladores a servicios
        $serviceMap = array(
            'App\Controllers\UserController' => [array( \App\Services\userService::class , 
                                                                   array(\App\Repositories\UserRepository::class,
                                                                         \App\Repositories\PerfilRepository::class))] , 
            'App\Controllers\LoginController' => [array(\App\Services\loginServices::class,
                                                                   array(\App\Repositories\UserRepository::class) )]  ,
            'App\Controllers\PerfilController' => [array(\App\Services\perfilService::class,
                                                                   array(\App\Repositories\PerfilRepository::class) )] ,
            'App\Controllers\FolderController' => [array(\App\Services\folderService::class,
                                                                   array(\App\Repositories\FolderRepository::class) )],
             'App\Controllers\ContenidoController' => [array(\App\Services\contenidoService::class,
                                                                   array(\App\Repositories\UserRepository::class,
                                                                         \App\Repositories\FolderRepository::class ) )]  
        );  

        $services = [];
        //echo $controllerName;
        if (isset($serviceMap[$controllerName])) {
            $db = DataBase::getInstance();
            foreach ($serviceMap[$controllerName] as $serviceDefinition) {
                
           
                 $serviceClass = $serviceDefinition[0];
            $repositoryClasses = $serviceDefinition[1]; 
            $repositories = array_map(fn($repoClass) => new $repoClass($db), $repositoryClasses);
            $services[] = new $serviceClass(...$repositories);
            }
        }

        return new $controllerName(...$services);
    }
}
