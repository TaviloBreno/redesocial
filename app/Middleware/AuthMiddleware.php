<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle($request, $next)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        return $next($request);
    }
}
