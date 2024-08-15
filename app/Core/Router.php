<?php

namespace App\Core;

class Router
{
    private $routes = [];

    // Adiciona uma rota ao sistema
    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    // Encontra e executa o manipulador da rota
    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $handler = $route['handler'];
                
                if (is_array($handler)) {
                    // Se o handler for um array (controlador e método)
                    list($controller, $action) = $handler;
                    $controller = "App\\Controllers\\$controller";
                    if (class_exists($controller)) {
                        $controllerInstance = new $controller;
                        if (method_exists($controllerInstance, $action)) {
                            $controllerInstance->$action();
                            return;
                        }
                    }
                } elseif (is_string($handler)) {
                    // Se o handler for uma string (no formato 'Controlador@Método')
                    list($controller, $action) = explode('@', $handler);
                    $controller = "App\\Controllers\\$controller";
                    if (class_exists($controller)) {
                        $controllerInstance = new $controller;
                        if (method_exists($controllerInstance, $action)) {
                            $controllerInstance->$action();
                            return;
                        }
                    }
                }
                throw new \Exception("Método $action não encontrado no controlador $controller.");
            }
        }
        // Se nenhuma rota correspondente for encontrada
        http_response_code(404);
        echo "Página não encontrada.";
    }
}
