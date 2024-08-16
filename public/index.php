<?php

require_once './../vendor/autoload.php'; 

use App\Core\Router;

// Instância do roteador
$router = new Router();

// Inclui os arquivos de rotas
require_once __DIR__ . '/../routes/web.php';;

// Obtém o método e URI da requisição
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Dispara a rota
$router->dispatch($method, $uri);
