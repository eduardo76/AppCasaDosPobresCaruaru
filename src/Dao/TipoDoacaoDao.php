<?php
namespace src\Dao;

use \src\models\TipoDoacao;

class TipoDoacaoDao {

    public static function getTiposDoacao(){

        $array = array();

        $sql = TipoDoacao::pdo()->prepare("SELECT id_tipo_doacao, descricao FROM tipo_da_doacao ORDER BY id_tipo_doacao");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;

    }

    public static function verifyTipoDoacao($id){

        $sql = TipoDoacao::pdo()->prepare("SELECT id_tipo_doacao, descricao FROM tipo_da_doacao WHERE id_tipo_doacao = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $info = $sql->fetch(\PDO::FETCH_OBJ);
            $tipoDoacao = new TipoDoacao();
            $tipoDoacao->setId($info->id_tipo_doacao);
            $tipoDoacao->setDescricao($info->descricao);
            return $tipoDoacao;
        }else{
            return false;
        }

    }

}
