<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Core\Database;
use App\Core\View;

class PostController
{
    private $postModel;
    private $commentModel;
    private $view;

    public function __construct()
    {
        $database = new Database(); // Certifique-se de passar a configuração correta
        $this->postModel = new Post($database);
        $this->commentModel = new Comment($database);
        $this->view = new View();
    }

    public function index()
    {
        $posts = $this->postModel->all();
        $this->view->render('posts/index', ['posts' => $posts]);
    }

    public function view($id)
    {
        $post = $this->postModel->find($id);
        if (!$post) {
            throw new \Exception("Post not found.");
        }
        $comments = $this->commentModel->getAllByPostId($id);
        $this->view->render('posts/view', ['post' => $post, 'comments' => $comments]);
    }

    public function create()
    {
        $this->view->render('posts/create');
        $this->postModel->create($_POST['user_id'], $_POST['content']);
        header("Location: /posts");
        exit();
    }

    public function addComment($postId)
    {
        if (!isset($_POST['user_id']) || !isset($_POST['content'])) {
            throw new \Exception("Invalid comment data.");
        }
        $userId = $_POST['user_id'];
        $content = $_POST['content'];
        $this->commentModel->create($postId, $userId, $content);
        
        // Redirect to a specific page
        header("Location: /posts/view/$postId");
        exit();
    }
}
