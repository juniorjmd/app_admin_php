<?php
namespace Core; 
use App\Views\base;
class Controller
{
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    { 
      
       $html = new base();
       if ($view == 'login'){
           $html->renderHtml('login','login',$data);}
           else{$html->renderHtml($view, 'Mantenimiento de usuario',$data);} 
    }
}
