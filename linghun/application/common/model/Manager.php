<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class Manager extends Base{

    protected $table = 'manager';

    /**
     * 根据搜索条件获取管理员列表信息
     */
    public function getManagerByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据条件获取所有管理员数量
     */
    public function getAllManager($where){
        return $this->where($where)->count();
    }

    /**
     * 根据管理员id获取信息
     */
    public function getOneManager($id){
        return $this->where('id',$id)->find();
    }

    /**
     * 插入管理员信息
     */
    public function insertManager($param){
        try{
            $result=$this->validate('ManagerValidate')->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加管理员成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑管理员信息
     */
    public function editManager($param){
        try{
            $result=$this->validate('ManagerValidate')->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑管理员成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除管理员
     */
    public function delManager($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除管理员成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}