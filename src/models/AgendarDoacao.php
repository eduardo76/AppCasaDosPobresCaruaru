<?php
namespace src\models;

use core\Model;

class AgendarDoacao extends Model {

    private $id;
    private $item;
    private $idDoador;
    private $quantidade;
    private $data;
    private $hora;
    private $lugar;
    private $idTipoDocao;
    private $telefone;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function getIdDoador()
    {
        return $this->idDoador;
    }

    public function setIdDoador($idDoador)
    {
        $this->idDoador = $idDoador;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function getLugar()
    {
        return $this->lugar;
    }

    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    public function getIdTipoDocao()
    {
        return $this->idTipoDocao;
    }

    public function setIdTipoDocao($idTipoDocao)
    {
        $this->idTipoDocao = $idTipoDocao;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

}
