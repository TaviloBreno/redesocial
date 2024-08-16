<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private $db;
    private $id; // Adiciona a propriedade id

    public function __construct($id = null)
    {
        $this->db = (new Database())->getPdo();
        $this->id = $id; // Inicializa a propriedade id
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
    public function update($username, $email, $password = null)
    {
        if ($this->id === null) {
            throw new \Exception("User ID is not set.");
        }

        $query = "UPDATE users SET username = :username, email = :email";
        if ($password) {
            $query .= ", password_hash = :password_hash";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':id' => $this->id
        ];
        if ($password) {
            $params[':password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }
        $stmt->execute($params);
    }

    // Verifica se o usuário possui um papel específico
    public function hasRole($roleName)
    {
        if ($this->id === null) {
            throw new \Exception("User ID is not set.");
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM user_roles
            JOIN roles ON user_roles.role_id = roles.id
            WHERE user_roles.user_id = :user_id AND roles.name = :role_name
        ");
        $stmt->execute(['user_id' => $this->id, 'role_name' => $roleName]);
        return $stmt->fetchColumn() > 0;
    }

    // Verifica se o usuário possui uma permissão específica
    public function hasPermission($permissionName)
    {
        if ($this->id === null) {
            throw new \Exception("User ID is not set.");
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM user_roles
            JOIN role_permissions ON user_roles.role_id = role_permissions.role_id
            JOIN permissions ON role_permissions.permission_id = permissions.id
            WHERE user_roles.user_id = :user_id AND permissions.name = :permission_name
        ");
        $stmt->execute(['user_id' => $this->id, 'permission_name' => $permissionName]);
        return $stmt->fetchColumn() > 0;
    }

    // Atribui um papel ao usuário
    public function assignRole($roleId)
    {
        if ($this->id === null) {
            throw new \Exception("User ID is not set.");
        }

        $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
        $stmt->execute([':user_id' => $this->id, ':role_id' => $roleId]);
    }

    // Remove um papel do usuário
    public function removeRole($roleId)
    {
        if ($this->id === null) {
            throw new \Exception("User ID is not set.");
        }

        $stmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = :user_id AND role_id = :role_id");
        $stmt->execute([':user_id' => $this->id, ':role_id' => $roleId]);
    }

    // Atribui uma permissão a um papel
    public function assignPermissionToRole($roleId, $permissionId)
    {
        $stmt = $this->db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)");
        $stmt->execute([':role_id' => $roleId, ':permission_id' => $permissionId]);
    }

    // Remove uma permissão de um papel
    public function removePermissionFromRole($roleId, $permissionId)
    {
        $stmt = $this->db->prepare("DELETE FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id");
        $stmt->execute([':role_id' => $roleId, ':permission_id' => $permissionId]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
