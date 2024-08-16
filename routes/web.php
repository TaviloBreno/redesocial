<?php


// Rotas Públicas
$router->add('GET', '/', 'HomeController@index');

// Rotas de Autenticação
$router->add('GET', '/login', 'AuthController@showLoginForm');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/register', 'AuthController@showRegistrationForm');
$router->add('POST', '/register', 'AuthController@register');

// Rotas de Postagens
$router->add('GET', '/posts/create', 'PostController@create', [AuthMiddleware::class, 'handle']);
$router->add('POST', '/posts', 'PostController@store', [AuthMiddleware::class, 'handle']);
$router->add('GET', '/posts', 'PostController@index');
$router->add('GET', '/posts/{id}', 'PostController@show');
$router->add('POST', '/posts/{id}/comments', 'PostController@addComment', [AuthMiddleware::class, 'handle']);

// Rotas de Amizade/Seguimento
$router->add('POST', '/friends/add', 'FriendshipController@add', [AuthMiddleware::class, 'handle']);
$router->add('POST', '/friends/remove', 'FriendshipController@remove', [AuthMiddleware::class, 'handle']);
$router->add('GET', '/users/{id}/friends', 'FriendshipController@list', [AuthMiddleware::class, 'handle']);

// Rotas de Perfil do Usuário
$router->add('GET', '/profile', 'UserController@profile', [AuthMiddleware::class, 'handle']);
$router->add('GET', '/profile/edit', 'UserController@editProfile', [AuthMiddleware::class, 'handle']);
$router->add('POST', '/profile/update', 'UserController@updateProfile', [AuthMiddleware::class, 'handle']);
