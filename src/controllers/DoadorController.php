<?php
namespace src\controllers;

use core\Request;
use \core\Controller;
use \src\Dao\DoadorDao;
use \src\models\Doador;
use function Sodium\add;

class DoadorController extends Controller {

    //Listando todos os usuários.
    public function index(){

      $this->validateJWT();

      $dados['loged'] = true;
      $dados['logedUser'] = $this->logedUser;
      $dados['doadores'] = DoadorDao::getAllUser();

      $this->response->json($dados);

    }//metodo

    public function login(){

        $array = array();

        // $metodo = parent::getMethodRequisition();
        // $data = parent::getRequestData();

        $metodo = $this->request->getMethod();
        $data = $this->request->all();

        if($metodo == "POST"){

            if(!empty($data['cpf']) && !empty($data['senha'])){
                $usuario = new Doador();
                $usuario->setCpf(addslashes($data['cpf']));
                $usuario->setSenha(addslashes($data['senha']));

                if(DoadorDao::login($usuario)){
                    //Gerando JTW para o id do usuário logado
                    $idLogedUser = $usuario->getLogedUser();
                    $nome = $usuario->getNome();
                    $array['jwt'] = DoadorDao::createJwt($idLogedUser, $nome);
                }else{
                    parent::setResponseStatus(403);
                    $array['error'] = "Acesso negado";
                }
            }else{
                parent::setResponseStatus(203);
                $array['error'] = "Preencha os campos e-mail e senha";
            }

        }else{
            parent::setResponseStatus(400);
            $array['error'] = "Método indisponível";
        }

        parent::returnJson($array);

    }

    //Listar usuário pelo id.
    public function getUserForId($args = array()){

        $this->validateJWT();

        $id = $args['id'];
        $usuario = DoadorDao::getUser($id);

        if($usuario){
          $dados = [
            'loged'     => true,
            'logedUser' => $this->logedUser,
            'isMe'      => DoadorDao::isMe($this->logedUser['id'], $id),
            'doador'    => $usuario
          ];

          $this->response->json($dados);
        } else {
          $this->response->json(["error" => "Doador não existe na base de dados"], 400);
        }

    }//metodo

    //Inserindo Usuário
    public function insertUser(){

        $array = array();
        $data  = $this->request->all();

        if(!empty($data['nome']) && !empty($data['email']) && !empty($data['senha']) && !empty($data['cpf'])){
          $this->response->json("Algum campo não foi preenchido", 400);
        }

        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
          $this->response->json("O e-mail enviado não é válido", 400);
        }

        $usuario = new Doador();
        $usuario->setNome(addslashes($data['nome']));
        $usuario->setEmail(addslashes($data['email']));
        $usuario->setSenha(addslashes($data['senha']));
        $usuario->setCpf(addslashes($data['cpf']));

        if(DoadorDao::insertUser($usuario)){
            $array['usuario'] = $usuario->getId();
            $array['success'] = 'Cadastro realizado';

            $this->response->json($array, 201);
        } else {
          $this->response->json(['error' => "Este e-mail ou CPF já existe na base de dados"]);
        }

        $this->response->json($array);

    }//metodo

    //Update de usuário
    public function updateUser($args = array()){

        $mudar = array();
        $array = array('loged' => false);

        $mudar['id'] = $args['id'];

        $metodo = $this->request->getMethod();
        $data = $this->request->all();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "PUT"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $array['isMe'] = DoadorDao::isMe($logedDoador->getLogedUser(), $args['id']);

                    if($array['isMe'] == true){

                        if(!empty($data['nome'])){
                            $mudar['nome'] = $data['nome'];
                        }

                        if(!empty($data['email'])){
                            if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                                if(DoadorDao::emailValidation($data['email'])){
                                    $mudar['email'] = addslashes($data['email']);
                                }else{
                                    $array['error'] = "Este e-mail já existe na base de dados";
                                }
                            }else{
                                $array['error'] = "Digite um e-mail válido";
                            }
                        }

                        if(!empty($data['cpf'])){
                            if(filter_var($data['cpf'], FILTER_SANITIZE_STRING)){
                                if(DoadorDao::cpfValidation($data['cpf'])){
                                    $mudar['cpf'] = addslashes($data['cpf']);
                                }else{
                                    $array['error'] = "Este CPF já existe na base de dados";
                                }
                            }else{
                                $array['error'] = "Este e-mail já existe na base de dados";
                            }
                        }

                        if(!empty($data['senha'])){
                            $mudar['senha'] = password_hash(addslashes($data['senha']), PASSWORD_DEFAULT);
                        }

                        if(DoadorDao::updateUser($args['id'], $mudar)){

                            $array['update'] = "Usuario alterado com sucesso";
                        }else{
                            parent::setResponseStatus(203);
                            $array['error'] = "Usuário não existe na base de dados";
                        }

                    }else{
                        parent::setResponseStatus(203);
                        $array['error'] = "Você não tem permissão para alterar este usuário.";
                    }

                }else{
                    parent::setResponseStatus(203);
                    $array['error'] = "Acesso negado";
                }

            }else{
                parent::setResponseStatus(203);
                $array['error'] = "Método indisponível";
            }

        }else{
            parent::setResponseStatus(203);
            $array['error'] = "Acesso negado";
        }

        parent::returnJson($array);

    }//metodo

    //Deletar usuario
    public function deleteUser($args = array()){

        $array = array('loged' => false);

        $metodo = $this->request->getMethod();
        $data = $this->request->all();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "DELETE"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $array['isMe'] = DoadorDao::isMe($logedDoador->getLogedUser(), $args['id']);

                    if($array['isMe'] == true){

                        if(DoadorDao::deleteUser($args['id']) == true){
                            $array['id'] = $args['id'];
                            $array['delete'] = "Usuário excluído com sucesso";
                        }else{
                            parent::setResponseStatus(203);
                            $array['error'] = "Usuário não existe na base de dados";
                        }

                    }else{
                        parent::setResponseStatus(203);
                        $array['error'] = "Você não tem permissão para excluir este usuário";
                    }

                }else{
                    parent::setResponseStatus(203);
                    $array['error'] = "Acesso negado";
                }
            }else{
                parent::setResponseStatus(203);
                $array['error'] = "Método de requisição indisponível";
            }

        }else{
            parent::setResponseStatus(203);
            $array['error'] = "Acesso negado";
        }

        parent::returnJson($array);

    }//metodo

}
