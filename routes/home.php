<?php

// Adiciona rotas relacionadas à página inicial
$router->add('GET', '/', [HomeController::class, 'index']);
