<?php

namespace App\Controllers;

use App\Models\Post;
use App\Core\Controller;
use App\Core\View;

class PostController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $post = new Post();
        $posts = $post->all();
        $this->view->render('post/index', ['posts' => $posts]);
    }

    public function create()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $this->view->render('post/create');
    }

    public function store()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $content = $_POST['content'] ?? '';

        if (empty($content)) {
            echo "O conteúdo da postagem não pode estar vazio!";
            return;
        }

        $post = new Post();
        try {
            $post->create($userId, $content);
            header("Location: /posts");
        } catch (\Exception $e) {
            echo "Erro ao criar postagem: " . $e->getMessage();
        }
    }

    public function show($id)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $post = new Post();
        $postData = $post->find($id);
        $this->view->render('post/show', ['post' => $postData]);
    }
}
