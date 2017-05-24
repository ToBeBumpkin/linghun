<?php
namespace app\index\controller;

class Comment extends Base{

    public function CommentAdd(){
        if (request()->isAjax()){
            $param=null;
            $param['name']=input('username');
            $param['content']=input('content');
            $param['email']=input('email');
            $param['pid']=input('pid');
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

    public function CommentList(){
        if (request()->isAjax()){
            $param=null;
            $param['pid']=input('pid');
            $param['type']=input('type');

            /*$where="('type=".$param['type']." AND pid=".$param['pid']."')";*/
            //$where="('type','ww')";
            $where=[];
            $where['type']=$param['type'];
            $where['pid']=$param['pid'];
            $where['pcid']=0;

            $comment=new \app\common\model\Comment();
            $selectResult=$comment->getCommentByWhere2($where);
            foreach ($selectResult as $key=>$vo){
                $id=$selectResult[$key]['id'];
                $where2=[];
                $where2['type']=$param['type'];
                $where2['pid']=$param['pid'];
                $where2['pcid']=$id;

                $replyid_p=$selectResult[$key]['replyid'];
                if (!isset($replyid_p)){
                    $commentinfo_p=$comment->getOneComment($replyid_p);
                    $selectResult[$key]['replyinfo']=$commentinfo_p;
                }

                $selectResult2=$comment->getCommentByWhere2($where2);

                if (!empty($selectResult2)){
                    foreach ($selectResult2 as $k=>$v){
                        $replyid=$selectResult2[$k]['replyid'];
                        if (isset($replyid)){
                            $commentinfo=$comment->getOneComment($replyid);
                            $selectResult2[$k]['replyinfo']=$commentinfo;
                        }
                    }

                    $selectResult[$key]['soncomment']=$selectResult2;
                }
            }

            return json($selectResult);
            /*return $where;*/
        }
        return $this->fetch();
    }


    public function commentList2(){
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