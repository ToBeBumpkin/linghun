<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class Ipcount extends Base{

    protected $table = 'ipcount';

    /**
     * 根据搜索条件获取记录列表信息
     */
    public function getIpcountByWhere2($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取记录列表信息
     */
    public function getIpcountByWhere($where){
        return  $this->where($where)->select();
    }

    /**
     * 根据搜索条件获取记录列表信息
     */
    public function getIpcountByWhere3(){
        return  $this->select();
    }

    /**
     * 根据条件获取所有访问数量
     */
    public function getAllIpcount($where){
        return $this->where($where)->count();
    }

    /**
     * 根据图文id获取文章
     */
    public function getOneArticle($id){
        return $this->where('id',$id)->find();
    }

    /**
     * 插入记录信息
     */
    public function insertIpcount($param){
        try{
            $result=$this->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加记录成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑记录信息
     */
    public function editIpcount($param){
        try{
            $result=$this->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑记录成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除文章
     */
    public function delArticle($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除文章成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}