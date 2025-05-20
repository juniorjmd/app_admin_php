<?php
 

namespace Core;

/**
 * Description of Router
 *
 * @author JosédeJesúsDomínguez
 */
class Router {
    private $namespace = 'App\Controllers';
    private $defaultController = 'HomeController';
    private $defaultMethod = 'index';

    public function parseUrl(): array
    {     
        $_base_path = (CARPETA_CONTENEDORA != '')? CARPETA_CONTENEDORA . 'admin/' : '/admin/' ; 
      $_url = ( isset($_GET['url']) && trim($_GET['url']) != '' )?   $_GET['url'] :$_SERVER['REQUEST_URI'];  
       if (strpos($_url, $_base_path) === 0) {
        $_url = substr($_url, strlen($_base_path));
    }
      
        if ($_url != '') {
            $url = explode('/', filter_var(rtrim($_url, '/'), FILTER_SANITIZE_URL));
            return array_map(function ($segment) {
                return preg_replace('/[^a-zA-Z0-9_-]/', '', $segment);
            }, $url);
        }
        return [];
    }

    public function getController(array &$url): string
    {  if( isset($url[0]) ) $url[0] = ucfirst($url[0]) ;  
        if (!empty($url) && file_exists( DOCUMENT_ROOT . '/admin/App/Controllers/' . $url[0] . 'Controller.php')) { 
            $controller = $url[0] . 'Controller';
            unset($url[0]);
        } else {
            $controller = $this->defaultController;
        }
        return $this->namespace . '\\' . $controller;
    }

    public function getMethod(array &$url , $controller): string
    {
         
        if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $method = $url[1];
                unset($url[1]);
                return $method;
            }
        }  
        return $this->defaultMethod;
    }

    public function getParams(array $url): array
    {
        return $url ? array_values($url) : [];
    }
}
