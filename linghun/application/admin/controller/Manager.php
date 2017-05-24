<?php
namespace app\admin\controller;

class Manager extends Base{

    //管理员列表
    public function managerList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['username']=['like','%'.$param['searchText'].'%'];
            }
            $manager=new \app\common\model\Manager();
            $selectResult=$manager->getManagerByWhere($where,$offset,$limit);

            foreach ($selectResult as $key=>$vo){
                $operate=[
                    '编辑'=>url('manager/managerEdit',['id'=>$vo['id']]),
                    '删除'=>"javascript:managerDel('".$vo['id']."')"
                ];

                $selectResult[$key]['operate']=showOperate($operate);
                if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }
            }

            $return['total']=$manager->getAllManager($where);
            $return['rows']=$selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加管理员
    public function managerAdd(){
        if (request()->isAjax()){
            $param=input('data');
            $param=parseParams($param);
            //return $param;

            if ($param['password'] !== $param['repassword']){
                return  ['code'=>-3,'data'=>'','msg'=>'两次密码不一致'];
            }
            unset($param['repassword']);

            $param['password']=md5($param['password']);
            $manager=new \app\common\model\Manager();
            $flag=$manager->insertManager($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }

        return $this->fetch();
    }

    //编辑角色
    public function managerEdit(){
        $manager=new \app\common\model\Manager();

        if (request()->isAjax()){
            $param=input('data');
            $param=parseParams($param);

            if ($param['password'] !== $param['repassword']){
                return  ['code'=>-3,'data'=>'','msg'=>'两次密码不一致'];
            }
            unset($param['repassword']);
            $param['password']=md5($param['password']);

            $flag=$manager->editManager($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $this->assign('manager',$manager->getOneManager($id));
        return $this->fetch();
    }

    //删除管理员
    public function managerDel(){
        $id=input('id');
        $manager=new \app\common\model\Manager();
        $flag=$manager->delManager($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}