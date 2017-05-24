<?php
namespace app\admin\controller;

class User extends Base{

    //用户列表
    public function userList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['username']=['like','%'.$param['searchText'].'%'];
            }
            $user=new \app\common\model\User();
            $selectResult=$user->getUserByWhere($where,$offset,$limit);

            foreach ($selectResult as $key=>$vo){
                $operate=[
                    /*'编辑'=>url('user/userEdit',['id'=>$vo['id']]),*/
                    '删除'=>"javascript:userDel('".$vo['id']."')"
                ];

                $selectResult[$key]['operate']=showOperate($operate);
                /*if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }*/
            }

            $return['total']=$user->getAllUser($where);
            $return['rows']=$selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加用户
    public function userAdd(){
        if (request()->isAjax()){
            $param=input('data');
            $param=parseParams($param);
            //return $param;

            if ($param['password'] !== $param['repassword']){
                return  ['code'=>-3,'data'=>'','msg'=>'两次密码不一致'];
            }
            unset($param['repassword']);

            $param['password']=md5($param['password']);
            $user=new \app\common\model\User();
            $flag=$user->insertUser($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }

        return $this->fetch();
    }

    //编辑用户
    public function userEdit(){
        $user=new \app\common\model\User();

        if (request()->isAjax()){
            $param=input('data');
            $param=parseParams($param);

            if ($param['password'] !== $param['repassword']){
                return  ['code'=>-3,'data'=>'','msg'=>'两次密码不一致'];
            }
            unset($param['repassword']);
            $param['password']=md5($param['password']);

            $flag=$user->editUser($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $this->assign('user',$user->getOneUser($id));
        return $this->fetch();
    }

    //删除用户
    public function userDel(){
        $id=input('id');
        $user=new \app\common\model\User();
        $flag=$user->delUser($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}