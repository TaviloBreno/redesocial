<?php

namespace App\Models;

use App\Core\Database;

class Friendship
{
    private $db;
    private $table = 'friendships';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Adicionar um novo relacionamento
    public function add($user_id, $friend_id)
    {
        $sql = "INSERT INTO {$this->table} (user_id, friend_id) VALUES (:user_id, :friend_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':friend_id', $friend_id);
        return $stmt->execute();
    }

    // Remover um relacionamento
    public function remove($user_id, $friend_id)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = :user_id AND friend_id = :friend_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':friend_id', $friend_id);
        return $stmt->execute();
    }

    // Verificar se já existe um relacionamento
    public function exists($user_id, $friend_id)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id AND friend_id = :friend_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':friend_id', $friend_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Listar amigos de um usuário
    public function getFriends($user_id)
    {
        $sql = "SELECT u.* FROM {$this->table} f JOIN users u ON f.friend_id = u.id WHERE f.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
