<?php

use App\Controllers\UserController;
use App\Core\Router;

// Adiciona rotas relacionadas aos usuários
$router->add('GET', '/user/register', [UserController::class, 'showRegistrationForm']);
$router->add('POST', '/user/register', [UserController::class, 'register']);
$router->add('GET', '/user/profile', [UserController::class, 'profile']);
$router->add('GET', '/user/settings', [UserController::class, 'settings']);
