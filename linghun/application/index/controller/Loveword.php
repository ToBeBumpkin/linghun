<?php
namespace app\index\controller;

class Loveword extends Base{

    public function lovewordList(){
        if (request()->isAjax()){
            $param=null;
            $param['pageSize']=input('pageSize');
            $param['pageNumber']=input('pageNumber');
            $param['searchText']=input('searchText');
            $param['autherText']=input('autherKW');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['content']=['like','%'.$param['searchText'].'%'];
            }
            if (isset($param['autherText']) && !empty($param['autherText'])){
                $where['auther']=['like','%'.$param['autherText'].'%'];
            }
            $loveword=new \app\common\model\Loveword();
            $selectResult=$loveword->getLovewordByWhere($where,$offset,$limit);

            $data['result']=$selectResult;
            $data['total']=$loveword->getAllLoveword($where);
            $data['totalPage']=ceil($data['total']/$param['pageSize']);

            return json($data);
        }
        return $this->fetch();
    }

    public function lovewordRandom(){
        if (request()->isAjax()){
            $randomnum=input('num');
            $loveword=new \app\common\model\Loveword();
            $randomLoveword=$loveword->randomLoveword($randomnum);
            return json($randomLoveword);
        }
    }

    public function lovewordAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['auther']=input('lusername');
            $param['content']=input('lcontent');
            $param['email']=input('lemail');
            $param['ip']=get_ip();
            $param['address']=GetIpLookup(get_ip());
            //$param['address']=GetIpLookup('101.95.16.50');
            $param['create_time']=date("Y-m-d H:i:s");

            $loveword=new \app\common\model\Loveword();
            $flag=$loveword->insertLoveword($param);
            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
            //return  json(['code'=>$flag['code'],'data'=>$param['address'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }

    public function lovewordlikeAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['id']=input('id');

            $loveword=new \app\common\model\Loveword();
            $lovewordnum=$loveword->getOneLoveword($param['id']);
            $param['like']=$lovewordnum['like']+1;

            $flag=$loveword->editLoveword($param);
            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
    }

    public function loveworddislikeAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['id']=input('id');

            $loveword=new \app\common\model\Loveword();
            $lovewordnum=$loveword->getOneLoveword($param['id']);
            $param['dislike']=$lovewordnum['dislike']+1;

            $flag=$loveword->editLoveword($param);
            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
    }



    public function lovewordDetail(){
        $loveword=new \app\common\model\Loveword();

        $id=input('id');
        $this->assign('loveword',$loveword->getOneLoveword($id));
        return $this->fetch();
    }

}