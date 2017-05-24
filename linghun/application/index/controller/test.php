public function ipcount(){
    $ip=get_client_ip(); //获取客户端IP
    ini_set('date.timezone','Asia/Shanghai');//设置时区
    $date=date('Y-m-d');//获取当前时间
    $yesterday=date("Y-m-d",strtotime("-1 day")); //获取昨天时间
    $yesterrow=M('ipcount')->field('nowdatec')->where('nowdate="'.$yesterday.'"')->select();
    $yesterdayc=0;
    for ($i=0;$i<count($yesterrow);$i++){
        $yesterdayc+=$yesterrow[$i]['nowdatec'];
    }
    $row=M('ipcount')->field('ip')->where('nowdate="'.$date.'"')->select();//查找今天的记录
    $n=1;
    $add=array(
        'nowdatec'=>$n,
        'nowdate'=>$date,
        'ip'=>$ip,
    );
    if(empty($row)){//判断并添加记录
        M('ipcount')->add($add);
    }
    $iprow=M('ipcount')->field('ip')->where('ip like "%'.$ip.'%" and nowdate="'.$date.'"')->select();//查找今天的ip记录
    $ipcount=$row[0]['ip'];
    if(empty($iprow)){ //判断并更新IP和统计记录
        $ipcount=$ipcount.$ip;
        $row1=M('ipcount')->field('nowdatec')->where('nowdate="'.$date.'"')->select();
        foreach($row1 as $cd){
            $dd= $cd['nowdatec'];
        }

        $dd+=1;
        $save=array(
            'nowdatec'=>$dd,
            'nowdate'=>$date,
            'ip'=>$ipcount,
        );
        M('ipcount')->where('nowdate="'.$date.'"')->save($save); //判断并更新IP和统计记录
    }
    $nowrow=M('ipcount')->field('nowdatec')->where('nowdate="'.$date.'"')->select();
    $nowsun=0;
    for ($i=0;$i<count($nowrow);$i++){
        $nowsun+=$nowrow[$i]['nowdatec'];
    }
    if(!empty($nowsun)){
        echo '今天访问量:',$nowsun,'</br>';//判断输出记录
    }else{
        echo '今天访问量:0</br>';
    };
    $rows=M('ipcount')->field('nowdatec')->select();
    $sun=0;
    for ($i=0;$i<count($rows);$i++){
        $sun+=$rows[$i]['nowdatec'];
    }

    if(!empty($yesterdayc)){
        echo '昨天访问量:',$yesterdayc,'</br>';//判断输出记录
    }else{
        echo '昨天访问量:0</br>';
    }

    if(!empty($sun)){
        echo '总访问量:',$sun,'</br>';//判断输出记录
    }else{
        echo '总访问量:0</br>';
    }





}