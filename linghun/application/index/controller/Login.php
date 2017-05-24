<?php
namespace app\index\controller;

class Login extends Base{

    public function index(){

        return $this->fetch();
    }

    public function login(){

        return $this->fetch('/login');
    }
}