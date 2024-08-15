<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getPdo();
    }

    public function create($userId, $content)
    {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, content) VALUES (:user_id, :content)");
        $stmt->execute([
            ':user_id' => $userId,
            ':content' => $content
        ]);
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
