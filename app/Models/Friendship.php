<?php

namespace App\Models;

use App\Core\Database;

class Friendship
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Envia uma solicitação de amizade
    public function sendRequest($userId, $friendId)
    {
        $query = "INSERT INTO friendship_requests (user_id, requester_id) VALUES (:user_id, :requester_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $friendId, \PDO::PARAM_INT);
        $stmt->bindParam(':requester_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    // Lista todos os amigos de um usuário
    public function listFriends($userId)
    {
        $query = "SELECT u.id, u.username FROM friendships f
                  JOIN users u ON (f.user_id = u.id OR f.friend_id = u.id)
                  WHERE (f.user_id = :user_id OR f.friend_id = :user_id) AND u.id != :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtém todas as solicitações de amizade para um usuário
    public function getRequestsByUserId($userId)
    {
        $query = "SELECT r.id, u.username 
                  FROM friendship_requests r
                  JOIN users u ON r.requester_id = u.id
                  WHERE r.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Aceita uma solicitação de amizade
    public function acceptRequest($userId, $requestId)
    {
        $pdo = $this->db->getPdo();

        // Começa uma transação
        $pdo->beginTransaction();

        try {
            // Remove a solicitação de amizade
            $query = "DELETE FROM friendship_requests WHERE user_id = :user_id AND requester_id = :request_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':request_id', $requestId, \PDO::PARAM_INT);
            $stmt->execute();

            // Adiciona uma nova amizade
            $query = "INSERT INTO friendships (user_id, friend_id) VALUES (:user_id, :friend_id), (:friend_id, :user_id)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $requestId, \PDO::PARAM_INT);
            $stmt->execute();

            // Confirma a transação
            $pdo->commit();
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            $pdo->rollBack();
            throw $e;
        }
    }

    // Rejeita uma solicitação de amizade
    public function rejectRequest($userId, $requestId)
    {
        $query = "DELETE FROM friendship_requests WHERE user_id = :user_id AND requester_id = :request_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':request_id', $requestId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    // Remove uma amizade
    public function removeFriendship($userId, $friendId)
    {
        $query = "DELETE FROM friendships WHERE (user_id = :user_id AND friend_id = :friend_id) OR (user_id = :friend_id AND friend_id = :user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':friend_id', $friendId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    // Obtém todas as amizades de um usuário
    public function getAllByUserId($userId)
    {
        $query = "SELECT u.id, u.username 
                  FROM friendships f
                  JOIN users u ON (f.user_id = u.id OR f.friend_id = u.id)
                  WHERE (f.user_id = :user_id OR f.friend_id = :user_id) AND u.id != :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
