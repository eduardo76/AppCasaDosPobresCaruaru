<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Usuario;
use \src\Dao\UsuarioDao;

class UsuarioController extends Controller {

    //Listando todos os usuários.
    public function index(){

        //$array = array('erro' => '');

        $method = parent::getMethodRequisition();

        if($method == 'GET'){

            $array['usuarios'] = UsuarioDao::getAllUser();

        }

        parent::returnJson($array);

    }//metodo

    public function login(){

        $array = array();

        $metodo = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if($metodo == "POST"){

            if(!empty($data['email']) && !empty($data['senha'])){
                $usuario = new Usuario();
                $usuario->setEmail(addslashes($data['email']));
                $usuario->setSenha(addslashes($data['senha']));

                if(UsuarioDao::login($usuario)){
                    //gerar JTW
                    //$array['logedUser'] = $usuario->getLogedUser();
                    $idLogedUser = $usuario->getLogedUser();
                    $array['jwt'] = UsuarioDao::createJwt($idLogedUser);
                }else{
                    $array['error'] = "Acesso negado";
                }
            }else{
                $array['error'] = "Preencha os campos e-mail e senha";
            }

        }else{
            $array['error'] = "Método indisponível";
        }

        parent::returnJson($array);

    }

    //Listar usuário pelo id.
    public function getUserForId($args = array()){

        $array = array('loged' => 'false');

        $method = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            if($array['logedUserId'] = UsuarioDao::validateJwt($data['jwt'])){

                $array['loged'] = true;

                if($method == "GET"){
                    $usuarios = UsuarioDao::getUser($args['id']);

                    if($usuarios){
                        $array['usuario'] = $usuarios;
                    }else{
                        http_response_code(404);
                        $array['error'] = "Usuário não existe na base de dados";
                    }
                }

            }else{
                http_response_code(401);
                $array['error'] = "Acesso negado";
            }

        }else{
            http_response_code(401);
            $array['error'] = "Acesso negado";
        }

        parent::returnJson($array);

    }//metodo

    //Inserindo Usuário
    public function insertUser(){

        $array = array();

        $method = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if($method == 'POST'){

            if(!empty($data['nome']) && !empty($data['email']) && !empty($data['senha'])){

                if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){

                    $usuario = new Usuario();
                    $usuario->setNome(addslashes($data['nome']));
                    $usuario->setEmail(addslashes($data['email']));
                    $usuario->setSenha(addslashes($data['senha']));

                    if(UsuarioDao::insertUser($usuario)){
                        $array['usuario'] = $usuario->getId();
                        $array['jwt'] = 'Token-JWT';
                        http_response_code(201);
                    }else{
                        $array['error'] = "Este e-mail já existe na base de dados";
                    }

                }else{
                    $array['error'] = "O e-mail enviado não é válido";
                }

            }else{
                $array['error'] = "Ops! Algum campo não foi preenchido";
            }

        }else{
            $array['error'] = "Método de requisição indisponível";
        }

        parent::returnJson($array);

    }//metodo

    //Update de usuário
    public function updateUser($args = array()){

        $mudar = array();
        $array = array();

        $mudar['id'] = $args['id'];

        $metodo = parent::getMethodRequisition();

        if($metodo == "PUT"){

            $data = parent::getRequestData();

            if(!empty($data['nome'])){
                $mudar['nome'] = $data['nome'];
            }
            if(!empty($data['email'])){
                if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    if(UsuarioDao::emailValidation($data['email'])){
                        $mudar['email'] = addslashes($data['email']);
                    }else{
                        $array['error'] = "Este e-mail já existe na base de dados";
                    }
                }else{
                    $array['error'] = "Digite um e-mail válido";
                }
            }
            if(!empty($data['senha'])){
                $mudar['senha'] = password_hash(addslashes($data['senha']), PASSWORD_DEFAULT);
            }

            if(UsuarioDao::updateUser($args['id'], $mudar)){
                $array['update'] = "Usuario alterado com sucesso";
            }else{
                $array['error'] = "Usuário não existe na base de dados";
            }
        }

        parent::returnJson($array);

    }//metodo

    //Deletar usuario
    public function deleteUser($args = array()){

        $array = array();

        $metodo = parent::getMethodRequisition();

        if($metodo == 'DELETE'){

            if(UsuarioDao::deleteUser($args['id']) == true){
                $array['id'] = $args['id'];
                $array['delete'] = "Usuário excluído com sucesso";
            }else{
                $array['error'] = "Usuário não existe na base de dados";
            }

        }

        parent::returnJson($array);

    }//metodo

}
