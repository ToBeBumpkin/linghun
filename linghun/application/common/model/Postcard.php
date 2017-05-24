<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class Postcard extends Base{

    protected $table = 'postcard';

    /**
     * 根据搜索条件获取明信片列表信息
     */
    public function getPostcardByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据条件获取所有明信片数量
     */
    public function getAllPostcard($where){
        return $this->where($where)->count();
    }

    /**
     * 根据明信片id获取信息
     */
    public function getOnePostcard($id){
        return $this->where('id',$id)->find();
    }


    /**
     * 插入明信片信息
     */
    public function insertPostcard($param){
        try{
            $result=$this->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加明信片成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑明信片信息
     */
    public function editPostcard($param){
        try{
            $result=$this->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑明信片成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除明信片
     */
    public function delPostcard($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除明信片成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}