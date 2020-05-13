<?php
namespace src\Dao;
use src\models\Usuario;

class UsuarioDao {

    public static function insertUser(Usuario $usuario){

        if(self::emailValidation($usuario->getEmail())){

            $senha = $usuario->getSenha();

            $usuario->setSenha(password_hash($senha, PASSWORD_DEFAULT));

            $sql = Usuario::pdo()->prepare("INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)");
            $sql->bindValue(":nome", $usuario->getNome());
            $sql->bindValue(":email", $usuario->getEmail());
            $sql->bindValue(":senha", $usuario->getSenha());
            $sql->execute();

            $usuario->setId(Usuario::pdo()->lastInsertId());

            return true;

        }else{
            return false;
        }
    }

    public static function emailValidation($email){

        $sql = Usuario::pdo()->prepare("SELECT id FROM usuario WHERE email = :email");
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

        $sql = Usuario::pdo()->prepare("SELECT id, nome, email FROM usuario");
        $sql->execute();

        return $array = $sql->fetchAll(\PDO::FETCH_OBJ);

    }

    public static function countUserForId($id){

        $sql = Usuario::pdo()->prepare("SELECT COUNT(*) AS total FROM usuario WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $count = $sql->fetch();

    }

    public static function getUser($id){

        $array = array();

        $count = self::countUserForId($id);

        if($count['total'] > 0){

            $sql = Usuario::pdo()->prepare("SELECT id, nome, email FROM usuario WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            $array = $sql->fetch(\PDO::FETCH_OBJ);
        }else{
            $array = "Usuário não existe na base de dados";
        }

        return $array;

    }

    public static function deleteUser($id){

        $count = self::countUserForId($id);

        if($count['total'] > 0){
            $sql = Usuario::pdo()->prepare("DELETE FROM usuario WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            return true;
        }else{
            return false;
        }

    }

    //Fazer método para verificar o usuário logado.

    public static function updateUser($id, $data){
        $fileds = array();
        $count = self::countUserForId($id);

        if ($count['total'] > 0) {

            if(count($data) > 0){

                foreach($data as $key => $value){
                    $fileds[] = $key.' = :'.$key;
                }

            }

            $query = "UPDATE usuario SET ".implode(',', $fileds)." WHERE id = :id";
            $sql = Usuario::pdo()->prepare($query);
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