<?php
namespace app\admin\controller;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
require_once EXTEND_PATH.'qiniu/autoload.php';


class Uploadfile extends Base{


    public function uploadFileAdd(){

        if ($_FILES["file"]["error"] > 0)
        {
            return json($_FILES["file"]["error"]);
        }
        else
        {
            $relpath=$_FILES["file"]["tmp_name"];
            $filename=$_FILES["file"]["name"];
            // 要上传的空间
            $ak=config('ak');
            $sk=config('sk');

            $auth=new Auth($ak,$sk);
            $bucketMgr=new BucketManager($auth);

            $bucket=config('bucket');

            // 生成上传 Token
            $token = $auth->uploadToken($bucket);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);  //后缀

            // 上传到七牛后保存的文件名
            $key = substr(md5($relpath) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();

            list($ret, $err) = $uploadMgr->putFile($token, $key, $relpath);

            if ($err !== null) {
                return  json(['code'=>-5,'data'=>'','msg'=>'上传文件出现错误']);
            } else {
                return  json(['code'=>1,'filePath'=>$key,'msg'=>'']);
            }
        }
    }


    public function uploadList(){


        // 要上传的空间
        $ak=config('ak');
        $sk=config('sk');

        $auth=new Auth($ak,$sk);
        $bucketMgr=new BucketManager($auth);

        $bucket=config('bucket');

        $prefix = '';
        // 上次列举返回的位置标记，作为本次列举的起点信息。
        $marker = '';
        // 本次列举的条目数
        //$limit = 3;
        // 列举文件
        $list = $bucketMgr->listFiles($bucket, $prefix, $marker);
        $list = array_filter($list);
        return json($list);

        // 生成上传 Token

    }

    public function uploadDel($imgpath){

        // 空间
        $ak=config('ak');
        $sk=config('sk');

        $auth=new Auth($ak,$sk);
        $bucketMgr=new BucketManager($auth);

        $bucket=config('bucket');

        $key=$imgpath;

        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        //echo "\n====> delete $key : \n";
        if ($err !== null) {
            return  json(['code'=>-5,'data'=>'','msg'=>'删除文件失败']);
        } else {
            return  json(['code'=>2,'data'=>'','msg'=>'删除文件成功']);
        }
    }
}