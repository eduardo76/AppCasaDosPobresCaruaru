<?php
namespace src\models;
use core\Model;

class Doador extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $logedUser;

    public function getLogedUser()
    {
        return $this->logedUser;
    }

    public function setLogedUser($logedUser)
    {
        $this->logedUser = $logedUser;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

}

?>
