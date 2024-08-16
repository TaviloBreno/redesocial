<?php

namespace App\Controllers;

use App\Models\Post;
use App\Core\Controller;

class PostController extends Controller
{
    // Função para exibir a página de criação de postagem
    public function create()
    {
        $this->view('posts/create'); // Renderiza a view para criar uma nova postagem
    }

    // Função para processar o formulário de criação de postagem
    public function store()
    {
        // Verifica se o método da requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém dados do formulário
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';

            // Valida os dados
            if ($title && $content) {
                // Cria uma nova postagem no banco de dados
                $post = new Post();
                $post->create($title, $content);

                // Redireciona para a lista de postagens
                header('Location: /posts');
                exit;
            } else {
                // Redireciona de volta com uma mensagem de erro
                header('Location: /posts/create?error=1');
                exit;
            }
        }
    }

    // Função para listar todas as postagens
    public function index()
    {
        $post = new Post();
        $posts = $post->all(); // Obtém todas as postagens do banco de dados

        // Renderiza a view com a lista de postagens
        $this->view('posts/index', ['posts' => $posts]);
    }

    // Função para visualizar uma postagem específica
    public function show($id)
    {
        $post = new Post();
        $postDetails = $post->find($id); // Obtém a postagem específica pelo ID

        if ($postDetails) {
            // Renderiza a view com os detalhes da postagem
            $this->view('posts/show', ['post' => $postDetails]);
        } else {
            // Redireciona para a lista de postagens com uma mensagem de erro
            header('Location: /posts?error=1');
            exit;
        }
    }
}
