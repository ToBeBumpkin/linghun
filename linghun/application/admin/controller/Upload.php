<?php
namespace app\admin\controller;

use think\App;

class Upload extends Base
{
    public function uploadimg()
    {

        if (request()->isPost()){

            /*$filename=input('file');
            $file=request()->file($filename);

            $info=$file->rule()*/

            $file = NULL;
            foreach(request()->file() as $f) {
                $file = $f;
                break;
            }

            if($file && $file->getSize() > 0) {
                $max_size = 1024 * 1024 * 10;
                $allow_ext_name = [
                    "jpg",
                    "jpeg",
                    "png",
                    "gif",
                ];

                //return json($file->getSize());

                if($file->getSize() <= $max_size) {
                    $ext_name = substr(strrchr($file->getInfo()["name"], '.'), 1);

                    if(in_array($ext_name, $allow_ext_name)) {

                        $uploads="static/upload/";

                        $info = $file->move($uploads);
                        $alluploads=config('web_res_upload');
                        $getsavename=$info->getSaveName();
                        $newfilepath=$alluploads.$getsavename;

                        if($info) {

                            //return  json(['code'=>0,'data'=>$newfilepath,'msg'=>'上传完成']);
                            return  json(['code'=>0,'data'=>['src'=>$newfilepath,'title'=>'图片'],'msg'=>'上传完成']);
                        }
                        return  json(['code'=>1,'data'=>'','msg'=>$file->getError()]);
                    }
                    else {
                        //return json(res_result(NULL, 1, "不允许上传此类文件"));
                        return  json(['code'=>1,'data'=>'','msg'=>'不允许上传此类文件']);
                    }
                }
                else {
                    //return json(res_result(NULL, 1, "不能上传超过10M的文件"));
                    return  json(['code'=>1,'data'=>'','msg'=>'不能上传超过10M的文件']);
                }
            }
            else {
                //return json(res_result(NULL, 1, "没有选择上传文件"));
                return  json(['code'=>1,'data'=>'','msg'=>'没有选择上传文件']);
            }

        }

    }
}