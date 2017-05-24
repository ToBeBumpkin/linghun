<?php
namespace app\index\controller;
use app\common\model\Ipcount;
use \think\Response;

class Index extends Base
{
    public function index()
    {
        return $this->fetch('/index');
    }

    public function indexpage(){
        return $this->fetch('index');
    }

    public function countnum(){
        $file=APP_PATH.'count.db';
        $fp=fopen($file,'r+');
        $content='';

        if (flock($fp,LOCK_EX)){
            while (($buffer=fgets($fp,1024))!=false){
                $content=$content.$buffer;
            }
            $data=unserialize($content);

            //设置记录键值
            $total='total';
            $month=date('Ym');
            $today=date('Ymd');
            $yesterday=date('Ymd',strtotime("-1 day"));
            $tongji=array();
            //总访问增加
            $tongji[$total]=$data[$total]+1;
            //本月访问量增加
            $tongji[$month]=$data[$month]+1;
            //几日访问量增加
            $tongji[$today]=$data[$today]+1;
            //保持昨天访问
            $tongji[$yesterday]=$data[$yesterday];

            //保存统计数据
            ftruncate($fp,0);   // 将文件截断到给定的长度
            rewind($fp);    // 倒回文件指针的位置
            fwrite($fp,serialize($tongji));
            flock($fp,LOCK_UN);
            fclose($fp);

            //输出数据
            $result['total']=$tongji[$total];
            $result['month']=$tongji[$month];
            $result['today']=$tongji[$today];
            $result['yesterday']=$tongji[$yesterday]?$tongji[$yesterday]:0;

            return json($result);
        }
    }


    public function ipcount(){

        $ip=get_ip();
        ini_set('date.timezone','Asia/Shanghai');
        $date=date('Y-m-d');
        $yesterday=date("Y-m-d",strtotime("-1 day"));  //获取昨天
        $ipcount=new \app\common\model\Ipcount();
        $where=[];
        $where['nowdate']=$yesterday;
        $yesterrow=$ipcount->getIpcountByWhere($where);
        $yesterdayc=0;
        for ($i=0;$i<count($yesterrow);$i++){
            $yesterdayc+=$yesterrow[$i]['nowdatec'];
        }
        $where2=[];
        $where2['nowdate']=$date;
        $row=$ipcount->getIpcountByWhere($where2);
        $n=1;
        $add=array(
            'nowdatec'=>$n,
            'nowdate'=>$date,
            'ip'=>$ip,
            'address'=>GetIpLookup($ip),
        );

        if (empty($row)){
            $ipcount->insertIpcount($add);
        }
        $where3=[];
        $where3['ip']=['like','%'.$ip.'%'];
        $where3['nowdate']=$date;
        $iprow=$ipcount->getIpcountByWhere($where3);
        $row=$ipcount->getIpcountByWhere($where2);
        $ipcount1=$row[0]['ip'];
        if (empty($iprow)){
            $ipcount1=$ipcount1." ".$ip;
            $row1=$ipcount->getIpcountByWhere($where2);
            foreach ($row1 as $cd){
                $dd=$cd['nowdatec'];
                $id=$cd['id'];
            }

            $dd+=1;

            $save=array(
                'id'=>$id,
                'nowdatec'=>$dd,
                'nowdate'=>$date,
                'ip'=>$ipcount1,
            );
            $ipcount->editIpcount($save);
        }

        $nowrow=$ipcount->getIpcountByWhere($where2);
        $nowsun=0;
        for ($i=0;$i<count($nowrow);$i++){
            $nowsun+=$nowrow[$i]['nowdatec'];
        }

        $rows=$ipcount->getIpcountByWhere3();
        $sun=0;
        for ($i=0;$i<count($rows);$i++){
            $sun+=$rows[$i]['nowdatec'];
        }

        $result['today']=$nowsun;
        $result['yesterday']=$yesterdayc;
        $result['count']=$sun;

        /*return $sun;*/
        return json($result);
    }
}
