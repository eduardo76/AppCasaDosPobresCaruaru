<?php
namespace core;

use src\Config;

class Request {

  private $data = [];
  private $headers = [];

  public function __construct(){
    $this->getRequestData();
    $this->getRequestHeaders();
  }

  public function get($variable) {
    if (isset($this->data[$variable])) {
      return $this->data[$variable];
    }

    return '';
  }

  public function header($variable) {
    if (isset($this->headers[$variable])) {
      return $this->headers[$variable];
    }

    return '';
  }

  public function all() {
    return $this->data;
  }

  public function allHeaders() {
    return $this->headers;
  }

  public function getMethod(){
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getApiToken() {
    if (isset($this->headers["X-API-KEY"])) {
      return $this->header("X-API-KEY");
    }

    return '';
  }

  public static function getUrl() {
    $url = filter_input(INPUT_GET, 'request');
    $url = str_replace(Config::BASE_DIR, '', $url);
    return '/'.$url;
  }

  private function getRequestData(){

    $this->data += $this->getQueryString();

    if ($this->isContenTypeJson()) {
      $this->data += $this->getRawData();
    }

    if($this->getMethod() == 'GET') {
      $this->data += $_GET;
    }

    if($this->getMethod() == 'POST') {
      $this->data += $_POST;
    }

    if(in_array($this->getMethod(), ['PUT', 'DELETE', 'PATCH']) && !$this->isContenTypeJson()) {
      if ($this->getContentType() == 'application/x-www-form-urlencoded') {
        parse_str(file_get_contents('php://input'), $data);
        $this->data += $data;
      }
    }

    return $this->data;
  }

  private function getRequestHeaders() {
    $headers = array();
    foreach($_SERVER as $key => $value) {
      if (substr($key, 0, 5) <> 'HTTP_') {
        continue;
      }
      $header = str_replace('_', '-', substr($key, 5));
      $headers[$header] = $value;
    }
    $this->headers = $headers;
  }

  private function getContentType(){
    return isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
  }

  private function getQueryString(){
    $queries = [];
    parse_str($_SERVER['QUERY_STRING'], $queries);
    return $queries;
  }

  private function isContenTypeJson(){
    return $this->getContentType() == 'application/json';
  }

  private function getRawData() {
    $raw_data = file_get_contents('php://input');
    if (!empty($raw_data)) {
      return json_decode($raw_data, true);
    }
  
    return '';
  }

}