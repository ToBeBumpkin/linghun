<?php
namespace app\index\controller;

class Article extends Base{

    public function articleList(){
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
            $article=new \app\common\model\Article();
            $selectResult=$article->getArticleByWhere($where,$offset,$limit);

            $data['result']=$selectResult;
            $data['total']=$article->getAllArticle($where);
            $data['totalPage']=ceil($data['total']/$param['pageSize']);

            return json($data);
        }
        return $this->fetch();
    }

    public function articleDetail(){
        $article=new \app\common\model\Article();

        $id=input('id');
        $this->assign('article',$article->getOneArticle($id));
        return $this->fetch();
    }
}