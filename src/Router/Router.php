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

        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
        } else {
            $this->show404();
        }
    }

    private function show404()
    {
        $smarty = getSmarty();
        $smarty->display('errors/404.tpl');
    }
}