<?php
namespace app\common\model;
use think\exception\PDOException;
use \think\response;

class Article extends Base{

    protected $table = 'article';

    /**
     * 根据搜索条件获取文章列表信息
     */
    public function getArticleByWhere($where,$offset,$limit){
        return  $this->where($where)->limit($offset,$limit)->order('id desc')->select();
    }

    /**
     * 根据条件获取所有文章数量
     */
    public function getAllArticle($where){
        return $this->where($where)->count();
    }

    /**
     * 根据图文id获取文章
     */
    public function getOneArticle($id){
        return $this->where('id',$id)->find();
    }

    /**
     * 插入文章信息
     */
    public function insertArticle($param){
        try{
            $result=$this->save($param);
            if ($result === false){
                return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
            }else{
                return  ['code'=>1,'data'=>'','msg'=>'添加文章成功'];
            }
        }catch (PDOException $e){
            return  ['code'=>-2,'data'=>'','msg'=>$e->getMessage()];
        }
    }

    /**
     * 编辑图文信息
     */
    public function editArticle($param){
        try{
            $result=$this->save($param,['id'=>$param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑文章成功'];
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