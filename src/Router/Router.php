<?php

namespace Biblioteca\Router;

class Router
{
    private $routes = [];

    public function add($route, $callback, $method = 'GET')
    {
        $method = strtoupper($method);
        $this->routes[$method][$route] = $callback;
    }

    public function dispatch($uri, $method)
    {
        $method = strtoupper($method);
        $found = false;

        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\[\w+:\w+\]/', '(\w+)', $route);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($callback, $matches);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->show404();
        }
    }

    private function show404()
    {
        $smarty = getSmarty();
        $smarty->display('errors/404.tpl');
    }
}