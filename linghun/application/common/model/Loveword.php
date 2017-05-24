<?php
namespace app\common\model;
use think\Db;
use think\exception\PDOException;
use \think\response;

class Loveword extends Base{

    protected $table = 'loveword';

    /**
     * 根据搜索条件获取loveword列表信息
     */
    public function getLovewordByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据条件获取所有Loveword数量
     */
    public function getAllLoveword($where){
        return $this->where($where)->count();
    }

    /**
     * 根据Loveword id获取Loveword
     */
    public function getOneLoveword($id){
        return $this->where('id',$id)->find();
    }

    /**
     * 插入Loveword信息
     */
    public function insertLoveword($param){
        try{
            $result=$this->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加Loveword成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑Loveword信息
     */
    public function editLoveword($param){
        try{
            $result=$this->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑Loveword成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 随机查询
     */
    public function randomLoveword($num){
        return Db::query('SELECT * FROM loveword WHERE id >= ((SELECT MAX(id) FROM loveword)-(SELECT MIN(id) FROM loveword)) * RAND() + (SELECT MIN(id) FROM loveword)  LIMIT ?',[$num]);
        /*return Db::query('select * from loveword order by rand() LIMIT ?',[$num]);*/
    }

    /**
     * 删除Loveword
     */
    public function delLoveword($id){
        try{
            $this->where('id',$id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除Loveword成功'];
        }catch (PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}