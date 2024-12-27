<?php

namespace Biblioteca\Router;

class Router
{
    private $routes = [];

    public function add($route, $callback, $method = 'GET')
    {
        $method = strtoupper($method);
        $this->routes[$method][$route] = $callback;
        echo "Route added: $method $route\n";
    }

    public function dispatch($uri, $method)
    {
        $method = strtoupper($method);
        echo "Dispatching: $method $uri\n";
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
        } else {
            echo "404 - Página não encontrada\n";
            echo "Available routes:\n";
            print_r($this->routes);
        }
    }
}
