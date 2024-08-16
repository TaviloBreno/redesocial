<?php


$router->add('GET', '/login', 'AuthController@login');
$router->get('/user/profile', [UserController::class, 'profile'], AuthMiddleware::class);