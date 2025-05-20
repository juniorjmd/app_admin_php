<?php 
namespace Core;

class View
{
    public static function render($view, $data = [])
    {
        require_once DOCUMENT_ROOT . '/admin/App/Views/' . $view . '.php';
    }
}
