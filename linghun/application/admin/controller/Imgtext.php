<?php
namespace app\admin\controller;

use app\admin\controller\Uploadimg;

class Imgtext extends Base{

    public function index(){

        return $this->fetch('demo');
    }

    public function imgtextList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['title']=['like','%'.$param['searchText'].'%'];
            }
            $imgtext=new \app\common\model\Imgtext();
            $selectResult=$imgtext->getImgtextByWhere($where,$offset,$limit);

            //return json('11111111111');

            foreach ($selectResult as $key=>$vo){
                $imgpath="<img class='kimgsize' src=".config('domain').$vo['imgpath']." >";
                $operate=[
                    '编辑'=>url('imgtext/imgtextEdit',['id'=>$vo['id']]),
                    '删除'=>"javascript:imgtextDel('".$vo['id']."')",
                    '详情'=>url('imgtext/imgtextDetail',['id'=>$vo['id']])
                ];

                $selectResult[$key]['imgpath']=$imgpath;
                $selectResult[$key]['operate']=showOperate($operate);
                /*if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }*/
            }

            $return['total']=$imgtext->getAllImgtext($where);
            $return['rows']=$selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    public function imgtextAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['title']=input('title');
            $param['content']=input('content');
            $param['imgpath']=input('imgpath');
            $param['create_time']=date("Y-m-d H:i:s");

            $imgtext=new \app\common\model\Imgtext();
            $flag=$imgtext->insertImgtext($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }

    public function imgtextAddtest(){
        return $this->fetch();
    }


    public function imgtextDel(){
        $id=input('id');
        /*$id=15;*/
        $imgtext=new \app\common\model\Imgtext();
        $imgpath=$imgtext->getOneImgtext($id)['imgpath'];
        /*echo $imgpath;
        exit();*/
        $flag=$imgtext->delImgtext($id);
        $uploadimg=new Uploadimg();
        $uploadimg->uploadDel($imgpath);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    public function imgtextEdit(){
        $imgtext=new \app\common\model\Imgtext();
        if (request()->isAjax()){
            $param=null;
            $param['id']=input('data.id');
            $param['title']=input('data.title');
            $param['content']=input('data.content');
            $param['imgpath']=input('data.imgpath');
            $param['update_time']=date("Y-m-d H:i:s");

            $flag=$imgtext->editImgtext($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $this->assign('imgtext',$imgtext->getOneImgtext($id));
        return $this->fetch();
    }

    public function imgtextDetail(){
        $imgtext=new \app\common\model\Imgtext();

        $id=input('id');
        $this->assign('imgtext',$imgtext->getOneImgtext($id));
        return $this->fetch();
    }
}