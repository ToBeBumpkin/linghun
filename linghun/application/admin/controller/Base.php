<?php
namespace app\admin\controller;


class Base extends \app\common\controller\Base{
    public function _initialize()
    {
        if (empty(session('username'))){
            $this->redirect(url('login/index'));
        }

        $this->assign([
            'username'=>session('username')
        ]);
    }
}