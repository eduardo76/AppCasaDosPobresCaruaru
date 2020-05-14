<?php
namespace src\controllers;

use core\Controller;

class ApiController extends Controller{

    public function index(){

        $this->returnJson("Bem vindo à API da casa dos pobres Caruaru");

    }

}
?>
