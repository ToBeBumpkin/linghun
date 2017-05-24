<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class User extends Base{

    protected $table = 'user';

    /**
     * 根据搜索条件获取用户列表信息
     */
    public function getUserByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据条件获取所有用户数量
     */
    public function getAllUser($where){
        return $this->where($where)->count();
    }

    /**
     * 根据用户id获取信息
     */
    public function getOneUser($id){
        return $this->where('id',$id)->find();
    }

    /**
     * 插入用户信息
     */
    public function insertUser($param){
        try{
            $result=$this->validate('UserValidate')->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加用户成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑用户信息
     */
    public function editUser($param){
        try{
            $result=$this->validate('UserValidate')->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑用户成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除用户
     */
    public function delUser($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除用户成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}