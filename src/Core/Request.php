<?php
// src/Core/Request.php

namespace Pedrojaraujo\Biblioteca\Core;


class Request
{
  public static function getbody()
  {
    $body = [];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      
      foreach ($_GET as $key => $value) {
        
        $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);

      }
     
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }


    if (in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'DELETE'])) {
      parse_str(file_get_contents('php://input'), $body);
    }

     return $body;

  }
}
