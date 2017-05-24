<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class Imgtext extends Base{

    protected $table = 'imgtext';

    /**
     * 根据搜索条件获取图文列表信息
     */
    public function getImgtextByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据条件获取所有图文数量
     */
    public function getAllImgtext($where){
        return $this->where($where)->count();
    }

    /**
     * 根据图文id获取信息
     */
    public function getOneImgtext($id){
        return $this->where('id',$id)->find();
    }


    /**
     * 插入图文信息
     */
    public function insertImgtext($param){
        try{
            $result=$this->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加图文成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑图文信息
     */
    public function editImgtext($param){
        try{
            $result=$this->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑图文成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除图文
     */
    public function delImgtext($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除图文成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}