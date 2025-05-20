<?php 
namespace App\Controllers; 
use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Home Page'];
        $this->view('home', $data);
    }

    public function about()
    {
        $data = ['title' => 'About Page'];
        $this->view('about', $data);
    }
 
}
