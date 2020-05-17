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
$router->get('/doacao/agendamentos/adm', 'AgendarDoacaoController@getAllAgendamentos');
$router->get('/doacao/agendamentos/doador/{id}/adm', 'AgendarDoacaoController@getAgendamentosForDoadorAdm');
$router->get('/doacao/agendamentos/doador/{id}', 'AgendarDoacaoController@getAgendamentosForDoador');
$router->put('/doacao/agendamentos/{id}/update', 'AgendarDoacaoController@updateAgendamentoDoacao');
$router->delete('/doacao/agendamentos/{id}/delete', 'AgendarDoacaoController@deleteAgendamentoDoacao');
//

//Doações Financeiras
