<?php


$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/login', 'AuthController@login');

$router->add('GET', '/posts/create', 'PostController@create'); // Exibe o formulário para criar uma nova postagem
$router->add('POST', '/posts', 'PostController@store');       // Armazena a nova postagem
$router->add('GET', '/posts', 'PostController@index');         // Lista todas as postagens
$router->add('GET', '/posts/{id}', 'PostController@show');     // Exibe uma postagem específica
$router->add('POST', '/posts/{id}/comments', 'PostController@addComment'); // Adiciona um comentário a uma postagem
