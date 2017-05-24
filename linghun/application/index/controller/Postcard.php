<?php
namespace app\index\controller;

use app\admin\controller\Uploadimg;
use app\admin\controller\Uploadfile;
/*明信片
Postcard
postcard*/
class Postcard extends Base{


    public function postcardList(){
        if (request()->isAjax()){
            $param=null;
            $param['pageSize']=input('pageSize');
            $param['pageNumber']=input('pageNumber');
            $param['searchText']=input('searchText');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['title']=['like','%'.$param['searchText'].'%'];
            }
            $postcard=new \app\common\model\Postcard();
            $selectResult=$postcard->getPostcardByWhere($where,$offset,$limit);

            $data['result']=$selectResult;
            $data['total']=$postcard->getAllPostcard($where);
            if ($data['total']){
                $data['totalPage']=ceil($data['total']/$param['pageSize']);
            }


            return json($data);
        }

        return $this->fetch();
    }


    public function postcardDetail(){
        $postcard=new \app\common\model\Postcard();

        $id=input('id');
        $this->assign('postcard',$postcard->getOnePostcard($id));
        return $this->fetch();
    }
}