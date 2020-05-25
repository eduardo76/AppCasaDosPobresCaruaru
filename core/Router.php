<?php
namespace core;

use \core\RouterBase;

class Router extends RouterBase {
    public $routes;

    public function get($endpoint, $trigger) {
        $this->routes['GET'][$endpoint] = $trigger;
    }

    public function post($endpoint, $trigger) {
        $this->routes['POST'][$endpoint] = $trigger;
    }

    public function put($endpoint, $trigger) {
        $this->routes['PUT'][$endpoint] = $trigger;
    }

    public function delete($endpoint, $trigger) {
        $this->routes['DELETE'][$endpoint] = $trigger;
    }

}