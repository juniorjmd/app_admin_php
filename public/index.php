<?php 
spl_autoload_register(function ($nombre_clase) { 
    $nomClass = '../' . str_replace('\\', '/', $nombre_clase) . '.php'; 
    if (file_exists($nomClass)) {
        require_once $nomClass;
    } 
});
 
use Core\Config ;
use Core\Container ;
use Core\Router; 
use Core\App ; 
// Inicializar la configuración
Config::load();   
$router = new Router();
$sessionManager = Container::get('sessionManager');
$app = new App($router, $sessionManager);
