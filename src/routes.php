<?php
use core\Router;

$router = new Router();

//Usuario
$router->get('/usuarios/{id}', 'UsuarioController@getUserForId');
$router->get('/usuarios', 'UsuarioController@index');
$router->post('/usuarios/new', 'UsuarioController@insertUser');
$router->put('/usuarios/{id}/update', 'UsuarioController@updateUser');
$router->delete('/usuarios/{id}/delete', 'UsuarioController@deleteUser');
//

//Doações

//
