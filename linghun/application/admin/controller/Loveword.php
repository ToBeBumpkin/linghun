<?php
namespace app\admin\controller;

class Loveword extends Base{

    public function index(){

        return $this->fetch('demo');
    }


    public function lovewordList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['content']=['like','%'.$param['searchText'].'%'];
            }
            $loveword=new \app\common\model\Loveword();
            $selectResult=$loveword->getLovewordByWhere($where,$offset,$limit);

            //return json('11111111111');

            foreach ($selectResult as $key=>$vo){
                $operate=[
                    '编辑'=>url('loveword/lovewordEdit',['id'=>$vo['id']]),
                    '删除'=>"javascript:lovewordDel('".$vo['id']."')",
                    '详情'=>url('loveword/lovewordDetail',['id'=>$vo['id']])
                ];

                $selectResult[$key]['operate']=showOperate($operate);
                /*if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }*/
            }

            $return['total']=$loveword->getAllLoveword($where);
            $return['rows']=$selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    public function lovewordAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['auther']=input('lusername');
            $param['content']=input('lcontent');
            $param['email']=input('lemail');
            $param['ip']=get_ip();
            $param['address']=GetIpLookup(get_ip());
            $param['create_time']=date("Y-m-d H:i:s");

            $loveword=new \app\common\model\Loveword();
            $flag=$loveword->insertLoveword($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }

    public function lovewordDel(){
        $id=input('id');
        $loveword=new \app\common\model\Loveword();
        $flag=$loveword->delLoveword($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    public function lovewordEdit(){
        $loveword=new \app\common\model\Loveword();
        if (request()->isAjax()){
            $param=null;
            $param['id']=input('data.id');
            $param['auther']=input('data.lusername');
            $param['content']=input('data.lcontent');
            $param['email']=input('data.lemail');

            $flag=$loveword->editLoveword($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $this->assign('loveword',$loveword->getOneLoveword($id));
        return $this->fetch();
    }

    public function lovewordDetail(){
        $loveword=new \app\common\model\Loveword();

        $id=input('id');
        $this->assign('loveword',$loveword->getOneLoveword($id));
        return $this->fetch();
    }
}