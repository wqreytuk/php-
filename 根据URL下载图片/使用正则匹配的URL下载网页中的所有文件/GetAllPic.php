<?php
require_once 'GetImage.php';
?>
<html>
<head>
<title>下载网页所有图片</title>
</head>
<body>
<form method="POST" action="getAllPic.php">
网页URL：
<input type="text" name="url" size="80" />
<input type="submit" name="submit" value="提交" /><br/>
<?php
if($_POST['submit'] != NULL) {
    //第一步. 先从网页中把所有<img ...> 用正则 抠出来.
    $url=$_POST['url'];
    $rs = parse_url($url);
    $main_url = $rs["host"];
    $baseurl = substr($url,0, strrpos($url,'/')+1);
    $opts = array('http' => array( 'request_fulluri' => true));
    $context = stream_context_create($opts);
    $message = file_get_contents($url, false, $context);//网页内容
    //正则表达式
    $reg = "/<img.*?src=\"(.*?)\".*?>/i";
    //把抠出来的 img 地址存放到 $img_array 变量中
    preg_match_all($reg, $message, $matches);
    for ($i=0; $i< count($matches[0]); $i++) {
        $matches[1][$i]=strtolower($matches[1][$i]);
        if(!strpos('a'.$matches[1][$i],'http')){
            if(strpos('a'.$matches[1][$i],'/')==1)
                $matches[1][$i]='http://'.$main_url.$matches[1][$i];
            else 
                $matches[1][$i]=$baseurl.$matches[1][$i];
        }  
    }
    //过滤重复的图片
    $img_array = array_unique($matches[1]);
    
    //第二步. 把$img_array 数组循环一下. 做图片保存处理
    mkdir('./data/');
    $Gimg = new DownImage();
    for ($i=0; $i< count($img_array); $i++) {
        //读取图片文件
        $Gimg->source = $img_array[$i];
        $Gimg->save_to = './data/';
        $FILE =  $Gimg->download(); //图片移动到本地
    }
    echo "下载完毕。";
}
?>
</form>
</body>
</html>
