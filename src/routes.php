<?php
use core\Router;

$router = new Router();

//Usuario
$router->post('/doador/login', 'DoadorController@login');
$router->get('/doador/{id}', 'DoadorController@getUserForId');
$router->post('/doador/new', 'DoadorController@insertUser');
$router->put('/doador/{id}/update', 'DoadorController@updateUser');
$router->delete('/doador/{id}/delete', 'DoadorController@deleteUser');
$router->get('/doadores', 'DoadorController@index');
$router->get('/', 'ApiController@index');

//

//Agendamento Doações
$router->post('/doacao/agendar', 'AgendarDoacaoController@insertAgendamentoDoacao');
//

//Doações Financeiras
