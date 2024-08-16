<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Friendship;
use App\Core\Controller;
use App\Core\View;

class UserController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    // Exibe o formulário de registro
    public function showRegistrationForm()
    {
        $this->view->render('user/register');
    }

    // Processa o registro do usuário
    public function register()
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            echo "Todos os campos são obrigatórios!";
            return;
        }

        $user = new User();
        try {
            $user->register($username, $password, $email);
            echo "Registro bem-sucedido!";
            header("Location: /login");
        } catch (\Exception $e) {
            echo "Erro ao registrar usuário: " . $e->getMessage();
        }
    }

    // Exibe o formulário de login
    public function showLoginForm()
    {
        $this->view->render('user/login');
    }

    // Processa o login do usuário
    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            echo "Todos os campos são obrigatórios!";
            return;
        }

        $user = new User();
        $authenticatedUser = $user->login($username, $password);

        if ($authenticatedUser) {
            session_start();
            $_SESSION['user'] = $authenticatedUser;
            header("Location: /profile");
        } else {
            echo "Usuário ou senha inválidos!";
        }
    }

    // Exibe o perfil do usuário
    public function profile()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $user = new User();
        $userData = $user->find($userId);
        $this->view->render('user/profile', ['user' => $userData]);
    }

    // Envia uma solicitação de amizade
    public function sendFriendRequest($friendId)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $friendship = new Friendship();
        try {
            $friendship->sendRequest($userId, $friendId);
            echo "Solicitação de amizade enviada!";
        } catch (\Exception $e) {
            echo "Erro ao enviar solicitação: " . $e->getMessage();
        }
    }

    // Aceita uma solicitação de amizade
    public function acceptFriendRequest($requestId)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $friendship = new Friendship();
        try {
            $friendship->acceptRequest($userId, $requestId);
            echo "Solicitação de amizade aceita!";
        } catch (\Exception $e) {
            echo "Erro ao aceitar solicitação: " . $e->getMessage();
        }
    }

    // Lista os amigos do usuário
    public function listFriends()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $friendship = new Friendship();
        $friends = $friendship->listFriends($userId);
        $this->view->render('user/friends', ['friends' => $friends]);
    }
}
