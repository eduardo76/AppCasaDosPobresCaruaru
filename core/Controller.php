<?php
namespace core;

use \src\Config;

class Controller {

    protected function redirect($url) {
        header("Location: ".$this->getBaseUrl().$url);
        exit;
    }

    private function getBaseUrl() {
        $base = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':'.$_SERVER['SERVER_PORT'];
        }
        $base .= Config::BASE_DIR;

        return $base;
    }

    public static function getMethodRequisition() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestData(){

        switch ($this->getMethodRequisition()){
            case 'GET':
                parse_str(file_get_contents('php://input'), $data);
                return (array) $data;
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $data);
                return (array) $data;
                break;
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $data);
                return (array) $data;
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'));
                if(is_null($data)){
                    $data = $_POST;
                }
                return (array) $data;
                break;
        }

    }

    public function returnJson($array){
        header("Content-Type: application/json");
        echo json_encode($array);
        exit;
    }

    public function setResponseStatus($status){
        return http_response_code($status);
    }

}
