<?php
namespace app\index\controller;

class Imgtext extends Base{

    public function index(){
        return $this->fetch('index');
    }

    public function imgtextList(){
        if (request()->isAjax()){

            $param=null;
            $param['pageSize']=input('data.pageSize');
            $param['pageNumber']=input('data.pageNumber');
            $param['searchText']=input('data.searchText');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['title']=['like','%'.$param['searchText'].'%'];
            }
            $imgtext=new \app\common\model\Imgtext();
            $selectResult=$imgtext->getImgtextByWhere($where,$offset,$limit);

            return json($selectResult);
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



    public function imgtextDel(){
        $id=input('id');
        $imgtext=new \app\common\model\Imgtext();
        $flag=$imgtext->delImgtext($id);
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