<?php
namespace app\admin\controller;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
require_once EXTEND_PATH.'qiniu/autoload.php';


class Uploadimg extends Base{


    public function uploadAdd(){

        $ak=config('ak');
        $sk=config('sk');

        $auth=new Auth($ak,$sk);

        $bucket=config('bucket');

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('uploadimginput');

        $getpath=$file->getRealPath();


        // 需要填写你的 Access Key 和 Secret Key
        /*$accessKey = '3kyJCDhOJKMP7cgkUCqYGjEeYdQ1jO_DkQVyBXWH';
        $secretKey = 'gvaBXHjV1mCH-0gN5o1I_aOx6WVALnln7K7867ft';*/

        // 构建鉴权对象
        /*$auth = new Auth($accessKey,$secretKey);*/

        // 要上传的空间
        /*$bucket = 'soul';*/

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀

        // 上传到七牛后保存的文件名
        $key = substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();

        list($ret, $err) = $uploadMgr->putFile($token, $key, $getpath);


        if ($err !== null) {
            return  json(['code'=>-5,'data'=>'','msg'=>'上传图片出现错误']);
        } else {
            return  json(['code'=>1,'data'=>$key,'msg'=>'']);
        }

        /*$soulqn=new Soulqn();
        $soulqn->soulsc('guid_close.png');
        return json(['one'=>'111','two'=>'222']);*/
        /*return json(['res'=>$res]);*/
        /*$uploads="static/upload/";

        $info=$file->move($uploads);

        $savename='';
        if ($info){
            $size=$info->getSize();
            $filename=$info->getFilename();
            $savename=$info->getSaveName();
        }


        return json(['one'=>'111','two'=>'222','size'=>$size,'filename'=>$filename,'savename'=>$savename,'file'=>$file]);*/
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

        // 要上传的空间
        $ak=config('ak');
        $sk=config('sk');

        $auth=new Auth($ak,$sk);
        $bucketMgr=new BucketManager($auth);

        $bucket=config('bucket');

        // 要上传的空间
        $key=$imgpath;

        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        //echo "\n====> delete $key : \n";
        if ($err !== null) {
            return  json(['code'=>-5,'data'=>'','msg'=>'删除图片失败']);
        } else {
            return  json(['code'=>2,'data'=>'','msg'=>'删除图片成功']);
        }
    }
}