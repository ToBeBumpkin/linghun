<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
require_once EXTEND_PATH.'qiniu/autoload.php';
// 应用公共文件
/**
 * 将字符解析成数组
 * @param $str
 */
function parseParams($str)
{
    $arrParams = [];
    parse_str(html_entity_decode(urldecode($str)), $arrParams);
    return $arrParams;
}

/**
 * 生成操作按钮
 *
 */

function showOperate($operate=[]){
    if (empty($operate)){
        return  '';
    }
/*    $option =   <<<EOT
<div class="btn-group">
    <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        操作<span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
EOT;*/
    $option="";

    foreach ($operate as $key=>$vo){
        $option .='<a class="btn btn-primary btn-xs" href="'.$vo.'">'.$key.'</a>&nbsp;';
    }

    return  $option;

}



//----获取客户机IP(string)----
function get_ip() {
    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if(isset($_SERVER["HTTP_CLIENT_IP"]))
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if(isset($_SERVER["REMOTE_ADDR"]))
        $ip = $_SERVER["REMOTE_ADDR"];
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else
        $ip = "Unknown";
    return $ip;
}

//根据IP获取物理地址
function GetIpLookup($ip=''){

    if (empty($ip)){
        return false;
    }
    if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $ip)) {
        return false;
    }
    $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    $res=json_decode(file_get_contents($url),true);

    if(empty($res)){ return false; }
    //$address=$res->data->country." ".$res->data->area." ".$res->data->region." ".$res->data->city;
    $address=$res['data'];
    if (empty($address)){
        return false;
    }
    $address=$address['country']." ".$address['area']." ".$address['region']." ".$address['city'];
    if (empty($address)){
        return false;
    }
    return $address;
}


//七牛云生成upbuceke token
function getQnToken(){
    $ak='3kyJCDhOJKMP7cgkUCqYGjEeYdQ1jO_DkQVyBXWH';
    $sk='gvaBXHjV1mCH-0gN5o1I_aOx6WVALnln7K7867ft';
    $bucket='soul';
    $auth=new Auth($ak,$sk);
    // 生成上传 Token
    $token = $auth->uploadToken($bucket);
    return $token;
}