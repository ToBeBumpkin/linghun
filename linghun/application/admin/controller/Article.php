<?php
namespace app\admin\controller;

class Article extends Base{

    public function index(){

        return $this->fetch('demo');
    }


    public function ArticleList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['title']=['like','%'.$param['searchText'].'%'];
            }
            $article=new \app\common\model\Article();
            $selectResult=$article->getArticleByWhere($where,$offset,$limit);

            //return json('11111111111');

            foreach ($selectResult as $key=>$vo){
                $operate=[
                    '编辑'=>url('article/articleEdit',['id'=>$vo['id']]),
                    '删除'=>"javascript:articleDel('".$vo['id']."')",
                    '详情'=>url('article/articleDetail',['id'=>$vo['id']])
                ];

                $selectResult[$key]['operate']=showOperate($operate);
                /*if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }*/
            }

            $return['total']=$article->getAllArticle($where);
            $return['rows']=$selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    public function articleAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['title']=input('title');
            $param['article']=input('article');
            $param['description']=input('description');
            $param['reprint']=input('reprint');
            $param['create_time']=date("Y-m-d H:i:s");

            $article=new \app\common\model\Article();
            $flag=$article->insertArticle($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }

    public function articleAddTest(){
        if (request()->isAjax()){
            $param=null;
            $param['title']=input('title');
            $param['description']=input('description');
            $param['article']=input('article');

            $article=new \app\common\model\Article();
            $flag=$article->insertArticle($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }


    public function articleDel(){
        $id=input('id');
        $article=new \app\common\model\Article();
        $flag=$article->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    public function articleEdit(){
        $article=new \app\common\model\Article();
        if (request()->isAjax()){
            $param=null;
            $param['id']=input('data.id');
            $param['title']=input('data.title');
            $param['description']=input('data.description');
            $param['article']=input('data.article');
            $param['reprint']=input('data.reprint');


            $flag=$article->editArticle($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $this->assign('article',$article->getOneArticle($id));
        return $this->fetch();
    }

    public function articleDetail(){
        $article=new \app\common\model\Article();

        $id=input('id');
        $this->assign('article',$article->getOneArticle($id));
        return $this->fetch();
    }
}