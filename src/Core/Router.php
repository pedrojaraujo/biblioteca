<?php

namespace Pedrojaraujo\Biblioteca\Core;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
  private $dispatcher;

  
  public function __construct()
  {
    $this->dispatcher = simpleDispatcher(function(RouteCollector $r) {
      // As rotas serão definidas no index.php
    });    
  }

  public function get($route, $handler) 
  {
    $this->dispatcher->addRoute('GET', $route, $handler);
  }

  public function post($route, $handler)
  {
    $this->dispatcher->addRoute('POST', $route, $handler);
  }

  public function put($route, $handler)
  {
    $this->addRoute('PUT', $route, $handler);
  }

  public function delete($route, $handler)
  {
    $this->dispatcher->addRoute('DELETE', $route, $handler);
  }


  public function dispatch()
  {
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    
    $pos = stripos($uri, '?');


    if ($pos !== false)  {

      $uri = substr($uri, 0, $pos);

    }

    $uri = rawurldecode($uri);

    $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

    switch($routeInfo[0]) {

      case \FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['message' => 'Rota não encontrada']);
        break;

      case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['message' => 'Método não permitido']);
        break;

      case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = explode('@', $handler);
        $controller= "Pedrojaraujo\\Biblioteca\\Controllers\\{$controller}";

        if (class_exists($controller) && method_exists($controller, $method)) {
          
          $instance = new $controller();
          call_user_func_array([$instance, $method], [$vars]);

        } else {
          http_response_code(500);
          echo json_encode(['message' => 'Erro interno do servidor']);
        }
        
        break;


    }


  }


}
