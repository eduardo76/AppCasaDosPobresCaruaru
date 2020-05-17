<?php
namespace src\Dao;

use src\models\AgendarDoacao;

class AgendarDoacaoDao {

    public static function insertAgendarDoacao(AgendarDoacao $doacao){

        $sql = AgendarDoacao::pdo()->prepare("INSERT INTO agendamento_doacao 
                                                  (item, id_doador, quantidade, date, hora, lugar, id_tipo_doacao)
                                                  VALUES (:item, :doador, :quantidade, :data, :hora, :lugar, :id_tipo_doacao)");

        $sql->bindValue(":item", $doacao->getItem());
        $sql->bindValue(":doador", $doacao->getIdDoador());
        $sql->bindValue(":quantidade", $doacao->getQuantidade());
        $sql->bindValue(":data", $doacao->getData());
        $sql->bindValue(":hora", $doacao->getHora());
        $sql->bindValue(":lugar", $doacao->getLugar());
        $sql->bindValue(":id_tipo_doacao", $doacao->getIdTipoDocao());
        $sql->execute();

        $doacao->setId(AgendarDoacao::pdo()->lastInsertId());

        return true;

    }

    public  static function getAllAgendamentos(){

        $array = array();

        $sql = AgendarDoacao::pdo()->prepare("SELECT *, 
                                                      (select nome from doador WHERE doador.id = a.id_doador) as doador,
                                                      (select descricao from tipo_da_doacao t WHERE t.id_tipo_doacao = a.id_tipo_doacao)
                                                      as tipo_doacao 
                                                      FROM agendamento_doacao a  ORDER BY id_agendamento DESC");
        $sql->execute();

        return $array = $sql->fetchAll(\PDO::FETCH_OBJ);

    }

    public static function getAgendamentoForDoador($id){

        $array = array();

        $sql = AgendarDoacao::pdo()->prepare("SELECT *, 
                                                      (select nome from doador WHERE doador.id = a.id_doador) as doador,
                                                      (select descricao from tipo_da_doacao t WHERE t.id_tipo_doacao = a.id_tipo_doacao)
                                                      as tipo_doacao 
                                                      FROM agendamento_doacao a WHERE a.id_doador = :id ORDER BY id_agendamento DESC");

        $sql->bindValue(":id", $id);
        $sql->execute();

        return $array = $sql->fetchAll(\PDO::FETCH_OBJ);

    }

    public static function updateDoacao($id, $data, $logedUserId){

        $fields = array();

        $count = self::countDoacaoForId($id, $logedUserId);

        if($count['total'] > 0){

            if(count($data) > 0){

                foreach ($data as $key => $value){
                    $fields[] = $key.' = :'.$key;
                }

            }

            $query = "UPDATE agendamento_doacao SET ".implode(',', $fields)." WHERE id_agendamento = :id";
            $sql = AgendarDoacao::pdo()->prepare($query);
            $sql->bindValue(":id", $id);

            foreach($data as $key => $value){
                $sql->bindValue(":".$key, $value);
            }

            $sql->execute();

            return true;

        }else{
            return false;
        }

    }

    public static function deleteAgendamentoDoacao($id){

        $count = self::countAgendamento($id);

        if($count['total'] > 0){
            $sql = AgendarDoacao::pdo()->prepare("DELETE FROM agendamento_doacao WHERE id_agendamento = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            return true;
        }else{
            return false;
        }

    }

    public static function countDoacaoForId($id, $logedUserId){

        $sql = AgendarDoacao::pdo()->prepare("SELECT COUNT(*) AS total FROM agendamento_doacao a WHERE a.id_agendamento = :id AND 
                                                      a.id_doador = :logedUserId");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":logedUserId", $logedUserId);
        $sql->execute();

        return $count = $sql->fetch();

    }

    public  static function countAgendamento($id){

        $sql = AgendarDoacao::pdo()->prepare("SELECT COUNT(*) AS total FROM agendamento_doacao WHERE id_agendamento = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $count = $sql->fetch();

    }

}
