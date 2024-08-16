<?php

namespace App\Middleware;

use App\Models\User;

class AuthMiddleware
{
    public function handle($request, $next)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = new User();
        $user->setId($_SESSION['user']['id']);
        $request->user = $user;

        return $next($request);
    }

    public function checkRole($roleName)
    {
        return function($request, $next) use ($roleName) {
            if (!$request->user->hasRole($roleName)) {
                header('HTTP/1.1 403 Forbidden');
                echo "Access denied";
                exit;
            }
            return $next($request);
        };
    }

    public function checkPermission($permissionName)
    {
        return function($request, $next) use ($permissionName) {
            if (!$request->user->hasPermission($permissionName)) {
                header('HTTP/1.1 403 Forbidden');
                echo "Access denied";
                exit;
            }
            return $next($request);
        };
    }
}