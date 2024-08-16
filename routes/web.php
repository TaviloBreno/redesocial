<?php


$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/login', 'AuthController@login');

$router->add('GET', '/posts/create', 'PostController@create');
$router->add('POST', '/posts', 'PostController@store');
$router->add('GET', '/posts', 'PostController@index');
$router->add('GET', '/posts/{id}', 'PostController@show');