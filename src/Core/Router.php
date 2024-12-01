<?php

namespace Pedrojaraujo\Biblioteca\Core;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
  private $routes = [];




  public function get($route, $handler)
  {
    $this->routes[] = ['GET', $route, $handler];
  }

  public function post($route, $handler)
  {
    $this->routes[] = ['POST', $route, $handler];
  }

  public function put($route, $handler)
  {
    $this->routes[] = ['PUT', $route, $handler];
  }

  public function delete($route, $handler)
  {
    $this->routes[] = ['DELETE', $route, $handler];
  }
  public function dispatch()
  {

    $dispatcher = simpleDispatcher(function (RouteCollector $r) {
      foreach ($this->routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
      }
    });

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // Normalização da URI
    if (false !== $pos = strpos($uri, '?')) {
      $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
    switch ($routeInfo[0]) {
      case \FastRoute\Dispatcher::NOT_FOUND:
        // Código para rota não encontrada
        break;
      case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // Código para método não permitido
        break;
      case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // Chamar o controlador e método apropriados
        list($controllerName, $methodName) = explode('@', $handler);
        $namespace = 'Pedrojaraujo\\Biblioteca\\Controllers\\';
        $fullControllerName = $namespace . $controllerName;
        $controller = new $fullControllerName();
        call_user_func_array([$controller, $methodName], $vars);
        break;
    }
  }
}
