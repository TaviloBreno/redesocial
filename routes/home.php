<?php

$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/login', 'AuthController@login');
