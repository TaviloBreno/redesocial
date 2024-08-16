<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Core\Database;

class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $database = new Database(); // Certifique-se de passar a configuração correta
        $this->commentModel = new Comment($database);
    }

    public function create($postId, $userId, $content)
    {
        $this->commentModel->create($postId, $userId, $content);
    }

    public function index($postId)
    {
        $comments = $this->commentModel->getAllByPostId($postId);
        // Renderizar a view com os comentários
    }

    public function view($id)
    {
        $comment = $this->commentModel->getById($id);
        // Renderizar a view com o comentário
    }
}
