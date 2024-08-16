<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Controller;
use App\Core\View;

class UserController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function showRegistrationForm()
    {
        $this->view->render('user/register');
    }

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

    public function showLoginForm()
    {
        $this->view->render('user/login');
    }

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
}
