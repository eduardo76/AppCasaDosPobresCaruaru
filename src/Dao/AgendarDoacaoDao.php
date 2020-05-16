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

}
