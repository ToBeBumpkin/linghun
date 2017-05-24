<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class Comment extends Base{

    protected $table = 'comment';

    /**
     * 根据搜索条件获取留言列表信息
     */
    public function getCommentByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id asc')->select();
    }

    /**
     * 根据搜索条件获取留言信息
     */
    public function getCommentByWhere2($where){
        return  $this->where($where)->order('id asc')->select();
    }

    /**
     * 根据条件获取所有留言数量
     */
    public function getAllComment($where){
        return $this->where($where)->count();
    }

    /**
     * 根据留言id获取信息
     */
    public function getOneComment($id){
        return $this->where('id',$id)->find();
    }


    /**
     * 插入留言信息
     */
    public function insertComment($param){
        try{
            $result=$this->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加留言成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑留言信息
     */
    public function editComment($param){
        try{
            $result=$this->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑留言成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除留言
     */
    public function delComment($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除留言成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}