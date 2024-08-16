<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Comment
{
    private $pdo;

    public function __construct(Database $database)
    {
        $this->pdo = $database->getPdo();
    }

    // Cria um novo comentário
    public function create($postId, $userId, $content)
    {
        $sql = 'INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Lista todos os comentários para um post específico
    public function getAllByPostId($postId)
    {
        $sql = 'SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Visualiza um comentário específico
    public function getById($id)
    {
        $sql = 'SELECT * FROM comments WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
