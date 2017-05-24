<?php
namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {
        return  $this->fetch('/index');
    }

    public function indexpage(){
        return  $this->fetch('index');
    }
}
