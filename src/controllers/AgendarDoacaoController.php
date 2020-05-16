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

    public static function insertAgendamentoDoacao(){

        $array = array('loged' => false);

        $metodo = parent::getMethodRequisition();
        $data = (new \core\Controller)->getRequestData();

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
                            && !empty($data['hora']) && !empty($data['lugar']) && !empty($data['tipoDoacao'])){

                            if(filter_var($data['quantidade'], FILTER_SANITIZE_NUMBER_INT)){

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

                                    //inserir Agendamento de doação no banco de dados

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
                                            'TipoDoacao' => $tipoDoacao->getDescricao()
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

}
