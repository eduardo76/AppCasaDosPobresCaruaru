<?php
namespace src\Dao;

use src\models\TipoTransacao;

class TipoTransacaoDao {

    public  static function getTiposTransacao(){

        $array = array();

        $sql = TipoTransacao::pdo()->prepare("SELECT id_transacao, descricao FROM tipo_transacao ORDER BY id_transacao");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;

    }

}
