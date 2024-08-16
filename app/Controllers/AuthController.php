<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Controller as BaseController;
use App\Core\View;

class AuthController extends BaseController
{
    private $userModel;
    private $view;

    public function __construct()
    {
        $this->userModel = new User();
        $this->view = new View();
    }

    // Método para registrar um novo usuário
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Verifica se o username e o email já existem (você pode adicionar isso no User Model)
            // Registra o usuário se os dados forem válidos
            $this->userModel->register($username, $password, $email);

            // Redireciona para a página de login ou outra página
            header('Location: /login');
            exit;
        }

        // Renderiza a view de registro (página de formulário de registro)
        $this->view->render('auth/login');
    }

    // Método para login do usuário
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Salva o usuário na sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redireciona para a página inicial ou perfil
                header('Location: /');
                exit;
            } else {
                // Renderiza a view de login com erro (usuário ou senha inválidos)
                $this->view->render('auth/login', ['error' => 'Usuário ou senha inválidos.']);
            }
        }

        // Renderiza a view de login (página de formulário de login)
        $this->view->render('auth/login', [
            'hide_header' => true,
            'hide_footer' => true,
            'title' => 'Login'
        ]);
    }

    // Método para logout do usuário
    public function logout()
    {
        // Destrói a sessão do usuário
        session_unset();
        session_destroy();

        // Redireciona para a página inicial ou de login
        header('Location: /login');
        exit;
    }
}
