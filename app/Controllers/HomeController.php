<?php



namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Post; 


class HomeController extends Controller
{
    public function index()
    {
        $view = new View();
        
        // Crie uma instância da classe de modelo de posts
        $postModel = new Post();
        
        // Chame um método para obter os posts do banco de dados
        $posts = $postModel->all();
        
        // Passe os posts para a view
        $view->render('home/index', ['title' => 'Welcome to Rede Social', 'posts' => $posts]);
    }
}