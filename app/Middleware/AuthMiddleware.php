<?php

namespace App\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public static function handle()
    {
        if (!Session::has('user_id')) {
            header('Location: /login');
            exit();
        }
    }
}