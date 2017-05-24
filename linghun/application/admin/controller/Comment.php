<?php
namespace app\admin\controller;


class Comment extends Base{

    public function index(){

        return $this->fetch('demo');
    }

    public function commentList(){
        if (request()->isAjax()){
            $param=input('param.');

            $limit=$param['pageSize'];
            $offset=($param['pageNumber']-1)*$limit;

            $where=[];
            if (isset($param['searchText']) && !empty($param['searchText'])){
                $where['title']=['like','%'.$param['searchText'].'%'];
            }
            $comment=new \app\common\model\Comment();
            $selectResult=$comment->getCommentByWhere($where,$offset,$limit);

            //return json('11111111111');

            foreach ($selectResult as $key=>$vo){
                $operate=[
                    '编辑'=>url('comment/commentEdit',['id'=>$vo['id']]),
                    '删除'=>"javascript:commentDel('".$vo['id']."')"
                ];

                $selectResult[$key]['operate']=showOperate($operate);
                /*if ($vo['id']==1){
                    $selectResult[$key]['operate']='';
                }*/
            }

            $return['total']=$comment->getAllComment($where);
            $return['rows']=$selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    public function commentAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['name']=input('name');
            $param['content']=input('content');
            $param['email']=input('email');
            $param['type']=input('type');
            $param['pcid']=input('pcid');
            $param['replyid']=input('replyid');
            $param['ip']=get_ip();
            $param['address']=GetIpLookup(get_ip());
            $param['create_time']=date("Y-m-d H:i:s");

            $comment=new \app\common\model\Comment();
            $flag=$comment->insertComment($param);

            return  json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
        }
        return $this->fetch();
    }



    public function commentDel(){
        $id=input('id');
        /*$id=15;*/
        $comment=new \app\common\model\Comment();
        /*echo $imgpath;
        exit();*/
        $flag=$comment->delComment($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    public function commentEdit(){
        $comment=new \app\common\model\Comment();
        if (request()->isAjax()){
            $param=null;
            $param['id']=input('data.id');
            $param['name']=input('data.name');
            $param['content']=input('data.content');
            $param['type']=input('data.type');
            $param['pcid']=input('data.pcid');
            $param['replyid']=input('data.replyid');
            $param['create_time']=input('data.create_time');
            $param['address']=input('data.address');
            $param['email']=input('data.email');

            $flag=$comment->editComment($param);
            //return json(['data'=>$param]);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id=input('id');
        $this->assign('comment',$comment->getOneComment($id));
        return $this->fetch();
    }

}