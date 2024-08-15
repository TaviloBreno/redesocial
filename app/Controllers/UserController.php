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

    // Exibe o formulário de registro
    public function showRegistrationForm()
    {
        $this->view->render('user/register');
    }

    // Processa o registro do usuário
    public function register()
    {
        // Recebe os dados do formulário
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Valida os dados
        if (empty($username) || empty($email) || empty($password)) {
            echo "Todos os campos são obrigatórios!";
            return;
        }

        // Cria o novo usuário
        $user = new User();
        try {
            $user->register($username, $password, $email);
            echo "Registro bem-sucedido!";
            // Redireciona para a página de login
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
        // Recebe os dados do formulário
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Valida os dados
        if (empty($username) || empty($password)) {
            echo "Todos os campos são obrigatórios!";
            return;
        }

        // Verifica o login do usuário
        $user = new User();
        $authenticatedUser = $user->login($username, $password);

        if ($authenticatedUser) {
            // Inicia a sessão e redireciona para o perfil
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
        // Verifica se o usuário está autenticado
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
