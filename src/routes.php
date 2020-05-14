<?php
use core\Router;

$router = new Router();

//Usuario
$router->post('/usuarios/login', 'UsuarioController@login');
$router->get('/usuarios/{id}', 'UsuarioController@getUserForId');
$router->post('/usuarios/new', 'UsuarioController@insertUser');
$router->put('/usuarios/{id}/update', 'UsuarioController@updateUser');
$router->delete('/usuarios/{id}/delete', 'UsuarioController@deleteUser');
$router->get('/usuarios', 'UsuarioController@index');
$router->get('/', 'ApiController@index');

//

//Doações

//
