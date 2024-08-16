<?php

$authMiddleware = function() {
    // Verifica se o usuário está autenticado
    session_start();
    if (!isset($_SESSION['user'])) {
        // Redireciona para a página de login se não estiver autenticado
        header("Location: /login");
        exit;
    }
};


// Rotas Públicas
$router->add('GET', '/', 'HomeController@index');

// Rotas de Autenticação
$router->add('GET', '/login', 'AuthController@showLoginForm');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/register', 'AuthController@showRegistrationForm');
$router->add('POST', '/register', 'AuthController@register');

// Rotas de Postagenss
$router->add('GET', '/posts/create', 'PostController@create', $authMiddleware);
$router->add('POST', '/posts', 'PostController@store', $authMiddleware);
$router->add('GET', '/posts', 'PostController@index');
$router->add('GET', '/posts/{id}', 'PostController@show');
$router->add('POST', '/posts/{id}/comments', 'PostController@addComment', [$authMiddleware, 'handle']);

// Rotas de Amizade/Seguimento
$router->add('POST', '/friends/add', 'FriendshipController@add', [$authMiddleware, 'handle']);
$router->add('POST', '/friends/remove', 'FriendshipController@remove', [$authMiddleware, 'handle']);
$router->add('GET', '/users/{id}/friends', 'FriendshipController@list', [$authMiddleware, 'handle']);

// Rotas de Perfil do Usuário
$router->add('GET', '/profile', 'UserController@profile', [$authMiddleware, 'handle']);
$router->add('GET', '/profile/edit', 'UserController@editProfile', [$authMiddleware, 'handle']);
$router->add('POST', '/profile/update', 'UserController@updateProfile', [$authMiddleware, 'handle']);