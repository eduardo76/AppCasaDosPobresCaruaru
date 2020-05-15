<?php
namespace src\Dao;
use src\models\Doador;
use src\models\Jwt;

class DoadorDao {

    public static function login(Doador $usuario){

        $sql = Doador::pdo()->prepare("SELECT id, nome, senha FROM doador WHERE email = :email");
        $sql->bindValue(":email", $usuario->getEmail());
        $sql->execute();

        if($sql->rowCount() > 0){
            $info = $sql->fetch(\PDO::FETCH_OBJ);

            if(password_verify($usuario->getSenha(), $info->senha)){
                $usuario->setLogedUser($info->id);
                $usuario->setNome($info->nome);
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    }

    public static function createJwt($idLogedUser, $nomeLogedUser){
        $jwt = new Jwt();
        return $jwt->create($array = array('idLogedUser' => $idLogedUser, 'nomeLogedUser' => $nomeLogedUser));
    }

    public static function validateJwt($token){
        $jwt = new Jwt();
        $info = $jwt->validate($token);

        if(isset($info->idLogedUser) && isset($info->nomeLogedUser)){

            $count = self::countUserForIdName($info->idLogedUser, $info->nomeLogedUser);

            if($count['total'] > 0){
                $usuario = new Doador();
                $usuario->setLogedUser($info->idLogedUser);
                $usuario->setNome($info->nomeLogedUser);
                return $usuario;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    //Verificando se usuário logado é o mesmo que está fazendo a requisição
    public  static function isMe($logedUserId, $requestId){
        return ($logedUserId == $requestId) ? true : false;
    }

    public static function insertUser(Doador $usuario){

        if(self::emailValidation($usuario->getEmail())){

            $senha = $usuario->getSenha();

            $usuario->setSenha(password_hash($senha, PASSWORD_DEFAULT));

            $sql = Doador::pdo()->prepare("INSERT INTO doador (nome, email, senha) VALUES (:nome, :email, :senha)");
            $sql->bindValue(":nome", $usuario->getNome());
            $sql->bindValue(":email", $usuario->getEmail());
            $sql->bindValue(":senha", $usuario->getSenha());
            $sql->execute();

            $usuario->setId(Doador::pdo()->lastInsertId());

            return true;

        }else{
            return false;
        }
    }

    public static function emailValidation($email){

        $sql = Doador::pdo()->prepare("SELECT id FROM doador WHERE email = :email");
        $sql->bindValue(":email",$email);
        $sql->execute();

        if($sql->rowCount() < 1){
            return true;
        }else{
            return false;
        }

    }

    public static function getAllUser(){

        $array = array();

        $sql = Doador::pdo()->prepare("SELECT id, nome, email FROM doador ORDER BY id DESC");
        $sql->execute();

        return $array = $sql->fetchAll(\PDO::FETCH_OBJ);

    }

    public static function countUserForId($id){

        $sql = Doador::pdo()->prepare("SELECT COUNT(*) AS total FROM doador WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $count = $sql->fetch();

    }

    //Verificar se o login está recebendo o token do usuário com o mesmo id e nome. Depois acrescentar o CPF.
    public static function countUserForIdName($id, $nome){

        $sql = Doador::pdo()->prepare("SELECT COUNT(*) AS total FROM doador WHERE id = :id AND nome = :nome");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nome", $nome);
        $sql->execute();

        return $count = $sql->fetch();

    }

    public static function getUser($id){

        $array = array();

        $count = self::countUserForId($id);

        if($count['total'] > 0){

            $sql = Doador::pdo()->prepare("SELECT id, nome, email FROM doador WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            $array = $sql->fetch(\PDO::FETCH_OBJ);
        }

        return $array;

    }

    public static function deleteUser($id){

        $count = self::countUserForId($id);

        if($count['total'] > 0){
            $sql = Doador::pdo()->prepare("DELETE FROM doador WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            return true;
        }else{
            return false;
        }

    }

    public static function updateUser($id, $data){
        $fileds = array();
        $count = self::countUserForId($id);

        if ($count['total'] > 0) {

            if(count($data) > 0){

                foreach($data as $key => $value){
                    $fileds[] = $key.' = :'.$key;
                }

            }

            $query = "UPDATE doador SET ".implode(',', $fileds)." WHERE id = :id";
            $sql = Doador::pdo()->prepare($query);
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

}
?>
