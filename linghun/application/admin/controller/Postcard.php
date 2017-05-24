<?php
namespace app\admin\controller;

use app\admin\controller\Uploadimg;
use app\admin\controller\Uploadfile;
/*明信片
Postcard
postcard*/
class Postcard extends Base{

    public function index(){

        return $this->fetch('demo');
    }

    public function postcardList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['title']=['like','%'.$param['searchText'].'%'];
            }
            $postcard=new \app\common\model\Postcard();
            $selectResult=$postcard->getPostcardByWhere($where,$offset,$limit);


            foreach ($selectResult as $key=>$vo){
                $filepath="<a href=".config('domain').$vo['filepath']." >".$vo['filepath']."</a>";
                $fountpath="<img class='kimgsize' src=".config('domain').$vo['fountpath']." >";
                $backpath="<img class='kimgsize' src=".config('domain').$vo['backpath']." >";
                $operate=[
                    '编辑'=>url('postcard/postcardEdit',['id'=>$vo['id']]),
                    '删除'=>"javascript:postcardDel('".$vo['id']."')",
                    '详情'=>url('postcard/postcardDetail',['id'=>$vo['id']])
                ];

                $selectResult[$key]['filepath']=$filepath;
                $selectResult[$key]['fountpath']=$fountpath;
                $selectResult[$key]['backpath']=$backpath;
                $selectResult[$key]['operate']=showOperate($operate);
                /*if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }*/
            }

            $return['total']=$postcard->getAllPostcard($where);
            $return['rows']=$selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    public function postcardAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['title']=input('title');
            $param['descript']=input('descript');
            $param['filepath']=input('filepath');
            $param['fountpath']=input('fountpath');
            $param['backpath']=input('backpath');
            $param['create_time']=date("Y-m-d H:i:s");

            $postcard=new \app\common\model\Postcard();
            $flag=$postcard->insertPostcard($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }



    public function postcardDel(){
        $id=input('id');
        /*$id=15;*/
        $postcard=new \app\common\model\Postcard();
        $file=$postcard->getOnePostcard($id);
        $filepath=$file['filepath'];
        $fountpath=$file['fountpath'];
        $backpath=$file['backpath'];
        /*echo $imgpath;
        exit();*/
        $flag=$postcard->delPostcard($id);
        $uploadimg=new Uploadimg();
        $uploadfile=new Uploadfile();
        $uploadimg->uploadDel($filepath);
        $uploadimg->uploadDel($fountpath);
        $uploadimg->uploadDel($backpath);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    public function postcardEdit(){
        $postcard=new \app\common\model\Postcard();

        if (request()->isAjax()){
            $param=null;
            $param['id']=input('data.id');
            $param['title']=input('data.title');
            $param['descript']=input('data.descript');
            /*$param['content']=input('data.content');
            $param['imgpath']=input('data.imgpath');*/
            $param['update_time']=date("Y-m-d H:i:s");

            $flag=$postcard->editPostcard($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $postcardinfo=$postcard->getOnePostcard($id);
        $this->assign('postcard',$postcardinfo);
        return $this->fetch();
    }

    public function postcardDetail(){
        $postcard=new \app\common\model\Postcard();

        $id=input('id');
        $this->assign('postcard',$postcard->getOnePostcard($id));
        return $this->fetch();
    }
}