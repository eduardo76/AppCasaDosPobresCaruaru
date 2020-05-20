<?php
namespace src\controllers;

use core\Controller;
use src\Dao\AgendarDoacaoDao;
use \src\models\AgendarDoacao;
use \src\models\TipoDoacao;
use \src\models\Doador;
use \src\Dao\DoadorDao;
use \src\Dao\TipoDoacaoDao;

class AgendarDoacaoController extends Controller {

    public function insertAgendamentoDoacao(){

        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == 'POST'){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $array['isMe'] = DoadorDao::isMe($logedUser['id'], $data['doador']);

                    if($array['isMe'] == true){

                        if(!empty($data['item']) && !empty($data['doador']) && !empty($data['quantidade']) && !empty($data['data'])
                            && !empty($data['hora']) && !empty($data['lugar']) && !empty($data['tipoDoacao']) && !empty($data['telefone'])){

                            if(filter_var($data['quantidade'], FILTER_SANITIZE_NUMBER_INT)){

                                if(filter_var($data['telefone'], FILTER_SANITIZE_NUMBER_INT)){

                                    if($tipoDoacao = TipoDoacaoDao::verifyTipoDoacao($data['tipoDoacao'])){

                                        $dataDoacao = explode('/', $data['data']);

                                        $dataDoacaoToBd = $dataDoacao[2].'-'.$dataDoacao[1].'-'.$dataDoacao[0];

                                        $doacao = new AgendarDoacao();

                                        $doacao->setItem(addslashes($data['item']));
                                        $doacao->setIdDoador($logedUser['id']);
                                        $doacao->setQuantidade(addslashes($data['quantidade']));
                                        $doacao->setData($dataDoacaoToBd);
                                        $doacao->setHora(addslashes($data['hora']));
                                        $doacao->setLugar(addslashes($data['lugar']));
                                        $doacao->setIdTipoDocao(addslashes($data['tipoDoacao']));
                                        $doacao->setTelefone(addslashes($data['telefone']));

                                        if(AgendarDoacaoDao::insertAgendarDoacao($doacao)){

                                            $array['agendamento'] = array(
                                                'id' => $doacao->getId(),
                                                'item' => $doacao->getItem(),
                                                'idDoador' => $doacao->getIdDoador(),
                                                'doador' => $logedUser['nome'],
                                                'quantidade' => $doacao->getQuantidade(),
                                                'data' => date('d/m/Y', strtotime($doacao->getData())),
                                                'hora' => $doacao->getHora(),
                                                'lugar' => $doacao->getLugar(),
                                                'idTipoDoacao' => $doacao->getIdTipoDocao(),
                                                'TipoDoacao' => $tipoDoacao->getDescricao(),
                                                'telefone' => $doacao->getTelefone()
                                            );

                                        }else{
                                            parent::setResponseStatus(203);
                                            $array['error'] = "Erro ao tentar inserir agendamento";
                                        }

                                    }else{
                                        parent::setResponseStatus(203);
                                        $array['error'] = "Tipo de doação não disponível";
                                    }
                                }else{
                                    parent::setResponseStatus(203);
                                    $array['error'] = "Digite um telefone válido";
                                }

                            }else{
                                parent::setResponseStatus(203);
                                $array['error'] = "Digite um valor inteiro para a quantidade";
                            }

                        }else{
                            parent::setResponseStatus(203);
                            $array['error'] = "Preencha todos os campos";
                        }

                    }else{
                        parent::setResponseStatus(203);
                        $array['error'] = "Você não tem permissão para agendar doação para outro usuário";
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

    }

    public function getAllAgendamentos(){

        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "GET"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $array['agendamentos'] = AgendarDoacaoDao::getAllAgendamentos();

                    if(count($array['agendamentos']) > 0){
                        foreach ($array['agendamentos'] as $agendamento){
                            $agendamento->date = date('d/m/Y', strtotime($agendamento->date));
                        }
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

    }

    public function getAgendamentosForDoadorAdm($args = array()){

        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "GET"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $array['agendamentos'] = AgendarDoacaoDao::getAgendamentoForDoador($args['id']);

                    if(count($array['agendamentos']) > 0){
                        foreach ($array['agendamentos'] as $agendamento){
                            $agendamento->date = date('d/m/Y', strtotime($agendamento->date));
                        }
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

    }

    public function getAgendamentosForDoador($args = array()){

        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "GET"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $array['isMe'] = DoadorDao::isMe($logedUser['id'], $args['id']);

                    if($array['isMe'] == true){
                        $array['agendamentos'] = AgendarDoacaoDao::getAgendamentoForDoador($args['id']);

                        if(count($array['agendamentos']) > 0){
                            foreach ($array['agendamentos'] as $agendamento){
                                $agendamento->date = date('d/m/Y', strtotime($agendamento->date));
                            }
                        }
                    }
                    else{
                        parent::setResponseStatus(203);
                        $array['error'] = "Você só pode visualizar seus próprios agendamentos";
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

    }

    public function updateAgendamentoDoacao($args = array()){

        $mudar = array();
        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();

        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "PUT"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    if(!empty($data['item'])){
                        $mudar['item'] = addslashes($data['item']);
                    }

                    /*if(!empty($data['doador'])){
                        $mudar['doador'] = addslashes($data['doador']);
                    }*/

                    if(!empty($data['quantidade'])){
                        if(filter_var($data['quantidade'], FILTER_SANITIZE_NUMBER_INT)){
                            $mudar['quantidade'] = $data['quantidade'];
                        }else{
                            $array['error'] = "Digite um valor inteiro para a quantidade";
                        }
                    }

                    if(!empty($data['data'])){
                        $dataArgs = explode('/', $data['data']);
                        $mudar['date'] = $dataArgs[2].'-'.$dataArgs[1].'-'.$dataArgs[0];
                    }

                    if(!empty($data['hora'])){
                        $mudar['hora'] = addslashes($data['hora']);
                    }

                    if(!empty($data['lugar'])){
                        $mudar['lugar'] = addslashes($data['lugar']);
                    }

                    if(!empty($data['tipoDoacao'])){
                        if($tipoDoacao = TipoDoacaoDao::verifyTipoDoacao($data['tipoDoacao'])){
                            $mudar['id_tipo_doacao'] = $tipoDoacao->getId();
                        }else{
                            $array['error'] = "Tipo de doação não disponível";
                        }
                    }

                    if(!empty($data['telefone'])){
                        $mudar['telefone'] = addslashes($data['telefone']);
                    }

                    if(AgendarDoacaoDao::updateDoacao($args['id'], $mudar , $logedUser['id'])){

                        if(!isset($array['error'])){
                            $array['update'] = "Agendamento alterada com sucesso";

                            $array['agendamento'] = AgendarDoacaoDao::getAgendamentoForId($args['id']);
                            $array['agendamento'][0]->date = date('d/m/Y', strtotime($array['agendamento'][0]->date));

                        }else{
                            $array['error'] = "Erro ao alterar agendamento";
                        }

                    }else{
                        parent::setResponseStatus(203);
                        $array['error'] = "Você só pode alterar suas próprias doações";
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

    }

    public function deleteAgendamentoDoacao($args = array()){

        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();
        $data = parent::getRequestData();

        if(!empty($data['jwt'])){

            $logedDoador = DoadorDao::validateJwt($data['jwt']);

            if($metodo == "DELETE"){

                if($logedDoador){

                    $logedUser = array('id' => $logedDoador->getLogedUser(), 'nome' => $logedDoador->getNome());

                    $array['logedUser'] = $logedUser;

                    $array['loged'] = true;

                    $countAgendamentoForId = AgendarDoacaoDao::countDoacaoForId($args['id'], $logedUser['id']);

                    if($countAgendamentoForId['total'] > 0){

                        $array['isMe'] = true;

                        if(AgendarDoacaoDao::deleteAgendamentoDoacao($args['id'])){
                            $array['delete'] = "Agendamento excluído com sucesso";
                        }else{
                            parent::setResponseStatus(203);
                            $array['error'] = "Agendamento não existe na base de dados";
                        }

                    }else{
                        $array['isMe'] = false;
                        parent::setResponseStatus(203);
                        $array['error'] = "Você não tem permissão para excluir este agendamento";
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

    }

}
