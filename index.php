<?php

session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

require './vendor/autoload.php';
require './src/routes.php';

$router->run( $router->routes );
