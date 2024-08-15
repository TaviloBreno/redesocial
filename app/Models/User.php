<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getPdo();
    }

    // Registra um novo usuário
    public function register($username, $password, $email)
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, password_hash, email) VALUES (:username, :password_hash, :email)");
        $stmt->execute([
            ':username' => $username,
            ':password_hash' => password_hash($password, PASSWORD_BCRYPT),
            ':email' => $email
        ]);
    }

    // Faz login do usuário
    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }

    // Encontra um usuário pelo ID
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualiza os dados do usuário
    public function update($id, $username, $email, $password = null)
    {
        $query = "UPDATE users SET username = :username, email = :email";
        if ($password) {
            $query .= ", password_hash = :password_hash";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':id' => $id
        ];
        if ($password) {
            $params[':password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }
        $stmt->execute($params);
    }
}
