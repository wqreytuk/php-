<?php
function getip() {
    //strcasecmp不区分大小写，相等则返回0，否则不相等
    if(getenv("http_client_ip") && strcasecmp(getenv("http_client_ip"), "unknown"))
        $ip = getenv("http_client_ip");
    else if (getenv("http_x_forwarded_for") && strcasecmp(getenv("http_x_forwarded_for"), "unknown"))
        $ip = getenv("http_x_forwarded_for");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_server["REMOTE_ADDR"]) && $_server["REMOTE_ADDR"] && trcasecmp($_server["REMOTE_ADDR"], "unknown"))
         $ip = $_server["REMOTE_ADDR"];
    else
        $ip = "unknown";
    return $ip;
}

$user_online = "count.txt"; //保存人数的文件
touch($user_online);//如果没有此文件，则创建
$timeout = 1000;//30秒内没动作者,认为掉线
$user_arr = file_get_contents($user_online);
$user_arr = explode('#',rtrim($user_arr,'#')); 
$temp = array();  
$ip = getip();
//第一次访问的时候$user_arr数组是空的，因此需要先判断一下
if(!empty($user_arr[0])) 
    foreach($user_arr as $value){
        $user = explode(",",trim($value));
       
        //判断地址是否相同，并判断这位用户是否已经过期，如果过期就不会进入temp数组，就不会被写到count.txt文件中
        if (($user[0] != $ip) && ($user[1] > time())) {//如果不是本用户IP并时间没有超时则放入到数组中
            array_push($temp,$user[0].",".$user[1]);
        }
    }

array_push($temp, $ip.",".(time() + ($timeout)).'#'); //保存本用户的信息
$user_arr = implode("#",$temp);
//写入文件
$fp = fopen($user_online,"w");
flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
fputs($fp,$user_arr);
flock($fp,LOCK_UN);
fclose($fp);
echo "当前有".count($temp)."人在线";
?>
