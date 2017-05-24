<?php
namespace app\admin\controller;

use think\Controller;
use org\Verify;
use app\common\validate;

class Login extends Controller{
    //登录页面
    public function index(){
        return $this->fetch('/login');
    }

    public function doLogin(){

        $param=input('data');
        $param=parseParams($param);
        $username=$param['username'];
        $password=$param['password'];
        $code=$param['code'];
        $result=$this->validate(compact('username', 'password', "code"),'ManagerLoginValidate');

        if(true !== $result){
            return json(['code' => -5, 'data' => '', 'msg' => $result]);
        }

        $verify=new Verify();
        if (!$verify->check($code)){
            return json(['code' => -4, 'data' => '', 'msg' => '验证码错误']);
        }

        $hasManager=db('manager')->where('username',$username)->find();
        if (empty($hasManager)){
            return json(['code' => -1, 'data' => '', 'msg' => '管理员不存在']);
        }
        if (md5($password) != $hasManager['password']){
            return json(['code' => -2, 'data' => '', 'msg' => '密码错误']);
        }

        //获取管理员的信息
        session('username',$username);
        session('id',$hasManager['id']);

        return json(['code' => 1, 'data' => url('admin/index/index'), 'msg' => '登录成功']);
    }

    //验证码
    public function checkVerify(){
        $verify=new Verify();
        $verify->imageH=32;
        $verify->imageW=100;
        $verify->length=4;
        $verify->useNoise=false;
        $verify->fontSize=14;
        return $verify->entry();
        //return '1111111';
    }


    //安全退出
    public function loginOut(){
        session('username',null);
        session('id',null);

        $this->redirect(url('index'));
    }
}