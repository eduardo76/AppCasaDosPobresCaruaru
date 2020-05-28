<?php

namespace core;

class Response {

  public static function json($array, $status = 200) {
    static::setStatus($status);
 
    header("Content-Type: application/json");
    if (is_array($array)) {
      echo json_encode($array);
    } else {
      echo $array;
    }

    exit;
  }

  public static function setStatus($status = 200){
    http_response_code($status);
  }
}